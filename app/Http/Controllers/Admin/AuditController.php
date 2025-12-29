<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Audit;
use App\Models\User;
use App\Models\AuditReport;
use App\Models\CertificationType;
use App\Models\AuditTracking;
use App\Models\Media;
use App\Models\AuditScore;
use App\Models\AuditorWalletTransaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuditController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Audit Show', only: ['index','show']),
            new Middleware('permission:Audit Create', only: ['create','store']),
            new Middleware('permission:Audit Edit', only: ['edit','update']), //,'update_audit_status'
            new Middleware('permission:Audit Delete', only: ['destroy','rollback_assign_audit']),
            new Middleware('permission:Audit Report', only: ['audit_report','upload_audit_report']),
        ];
    }

    public function index()
    {
        if(Auth::user()->hasRole('Super Admin')){
            // $audits = Audit::all();
            $audits = Audit::orderBy('id', 'desc')->get();
        }elseif(Auth::user()->hasRole('Auditor')){
            $audits = Audit::where('auditor_id',Auth::id())->where('status','!=','Complete')->orderBy('id', 'desc')->get();
        }else{
            $audits = Audit::where('user_id',Auth::id())->orderBy('id', 'desc')->get();
        }

        $auditors = User::role('auditor')->where('status', 1)->get();
        return view('admin.audit_requests.index',compact('audits','auditors'));
    }

    public function create()
    {
        $users = User::role('User')->get();
        $certification_types = CertificationType::where('is_visible',1)->get();
        return view('admin.audit_requests.create',compact('users','certification_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|exists:users,id',
            'certification' => 'required|exists:certification_types,id',
            'audit_date' => 'required|date|after_or_equal:today',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $audit = new Audit();
            $audit->user_id = $request->user;
            $audit->certification_type_id = $request->certification;
            $audit->audit_date = format_date_for_db($request->audit_date);
            $res = $audit->save();

            AuditTracking::create([
                'audit_id' => $audit->id,
                'description' => 'Placed'
            ]);

            if($res){
                return back()->with('success','Audit Enquiry Placed Successfully');
            }else{
                return back()->with('success','Audit Enquiry Not Placed');
            }
        }
    }

    public function show(Audit $audit)
    {
        //
    }

    public function edit(string $id)
    {
        $audit = Audit::findOrFail($id);
        $users = User::role('User')->get();
        $certification_types = CertificationType::where('is_visible',1)->get();
        return view('admin.audit_requests.edit',compact('users','certification_types','audit'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'user' => 'required|exists:users,id',
            'certification' => 'required|exists:certification_types,id',
            'audit_date' => 'required|date|after_or_equal:today',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $audit = Audit::findOrFail($id);
            $audit->user_id = $request->user;
            $audit->certification_type_id = $request->certification;
            $audit->audit_date = format_date_for_db($request->audit_date);
            $res = $audit->update();

            if($res){
                return back()->with('success','Audit Enquiry Placed Successfully');
            }else{
                return back()->with('success','Audit Enquiry Not Placed');
            }
        }
    }

    public function destroy(string $id)
    {
        $audit = Audit::findOrFail($id);
        $res = $audit->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }

    public function update_audit_status(Request $request){
        $validator = Validator::make($request->all(), [
            'audit_id' => 'required|exists:audits,id',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }else{
            $audit = Audit::findOrFail($request->audit_id);
            $audit->status = $request->status;
            if(isset($request->auditor) && isset($request->payment_amount)){
                $audit->auditor_id = $request->auditor;
                $audit->payment_amount = $request->payment_amount;
            }
            $res = $audit->update();

            AuditTracking::create([
                'audit_id' => $audit->id,
                'description' => $request->status
            ]);

            if($res){
                return back()->with('success','Audit Status Updated Successfully');
            }else{
                return back()->with('success','Audit Status Not Updated');
            }
        }
    }

    public function rollback_assign_audit(string $id){
        $audit = Audit::findOrFail($id);
        $audit->status = 'Approved';
        $audit->auditor_id = NULL;
        $audit->payment_amount = 0.00;
        $res = $audit->update();

        if($res){
            return back()->with('success','Audit Cancelled Successfully');
        }else{
            return back()->with('success','Audit Not Cancelled');
        }
    }

    public function audit_report(string $id){
        $audit = Audit::findOrFail($id);
        $audit_reports = AuditReport::where('audit_id',$audit->id)->get();
        $audit_stacks = AuditTracking::where('audit_id',$audit->id)->get();
        $inspectionCategories = $audit->inspectionCategories();
        // return $inspectionCategories;
        $auditScores = AuditScore::where('audit_id', $id)->get()->keyBy(function($score) {
            return $score->inspection_item_id;
        });
        return view('admin.audit_requests.report',compact('audit','audit_reports','audit_stacks','auditScores','inspectionCategories'));
    }

    public function upload_audit_report(Request $request,string $id)
    {
        $data = $request->validate([
            'rating' => 'required|array',
            'rating.*' => 'required|array',
            'rating.*.*' => 'required|in:0,1,2',
            'comment' => 'nullable|array',
            'comment.*' => 'nullable|array',
            'comment.*.*' => 'nullable|string',
        ]);
    
        $audit_id = $request->input('audit_id');
        
        // Loop through ratings and comments
        foreach ($data['rating'] as $categoryId => $items) {
            foreach ($items as $itemId => $score) {
                // Check if the record already exists
                $auditScore = AuditScore::where('audit_id', $id)
                                        ->where('inspection_item_id', $itemId)
                                        ->first();
    
                if ($auditScore) {
                    // Update existing record
                    $auditScore->score = $score;
                    $auditScore->notes = $data['comment'][$categoryId][$itemId] ?? null;
                    $auditScore->save();
                } else {
                    // Create new record if it doesn't exist
                    AuditScore::create([
                        'audit_id' => $id,
                        'inspection_item_id' => $itemId,
                        'score' => $score,
                        'notes' => $data['comment'][$categoryId][$itemId] ?? null,
                    ]);

                    AuditTracking::create([
                        'audit_id' => $id,
                        'description' => 'Report Uploaded'
                    ]);
                }
            }
        }
    
        return redirect()->route('audit.audit-report', $id)->with('success', 'Audit report updated successfully!');
    }

    // public function upload_audit_report(Request $request,string $id){
    //     // return $request->all();
    //     $request->validate([
    //         // 'file.*' => 'required|file|mimes:pdf,jpg,png|max:2048',
    //         'description' => 'required',
    //     ]);

    //     $audit = Audit::findOrFail($id);
    //     if($audit){
    //         $audit_report = new AuditReport();
    //         $audit_report->audit_id = $id;
    //         $audit_report->description = $request->description;
    //         if ($request->hasFile('file')) {
    //             foreach ($request->file('file') as $input_file) {
    //                 $audit_report->addMedia($input_file)->toMediaCollection('audit-report-file');
    //             }
    //         }
    //         $audit_report->uploaded_by = Auth::id();
    //         $audit_report->is_draft = $request->is_draft;

    //         if($audit_report->save()){
    //             $audit->status = 'Report Uploaded';
    //             $audit->update();
    //             AuditTracking::create([
    //                 'audit_id' => $audit->id,
    //                 'description' => 'Report Uploaded'
    //             ]);
    //             return back()->with('success','Audit Report Added Successfully');
    //         }else{
    //             return back()->with('success','Audit Report Not Added');
    //         }
    //     }else{
    //         return back()->with('success','Audit Not Found');
    //     }
    // }

    public function audit_report_edit(string $id){
        $auditReport = AuditReport::with('media')->findOrFail($id);
        $files = $auditReport->getMedia('audit-report-file')->map(function ($file) {
            return [
                'id' => $file->id,
                'name' => $file->file_name,
                'url' => $file->getUrl(),
            ];
        });
    
        return response()->json([
            'id' => $auditReport->id,
            'description' => $auditReport->description,
            'is_draft' => $auditReport->is_draft,
            'files' => $files,
        ]);
    }

    public function update_upload_audit_report(Request $request,string $id){
        // return $request->all();
        $request->validate([
            // 'file.*' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'description' => 'required',
        ]);

        $audit_report = AuditReport::findOrFail($id);
        if($audit_report){
            $audit_report->description = $request->description;
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $input_file) {
                    $audit_report->addMedia($input_file)->toMediaCollection('audit-report-file');
                }
            }
            $audit_report->is_draft = $request->is_draft;

            if($audit_report->update()){
                return back()->with('success','Audit Report Updated Successfully');
            }else{
                return back()->with('success','Audit Report Not Updated');
            }
        }else{
            return back()->with('success','Audit Report Not Found');
        }
    }

    public function delete_audit_file(string $id,string $fileId){
        $auditReport = AuditReport::findOrFail($id);
        if ($auditReport) {
            // Get the media file by ID (replace `file_id` with the actual column or parameter for file ID)
            $media = $auditReport->getMedia('audit-report-file')->where('id', $fileId)->first();
    
            if ($media) {
                // Delete the media
                $media->delete();
                return response()->json(['message' => 'File deleted successfully.']);
            }
        }

    }

    public function delete_audit_report(string $id){
        $auditReport = AuditReport::findOrFail($id);
        $res = $auditReport->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }

    public function approved_audit_report(string $id){
        $auditReport = AuditReport::findOrFail($id);
        $auditReport->is_approved = 1;
        $res = $auditReport->update();
        $audit = Audit::findOrFail($auditReport->audit_id);
        $audit->status = 'Complete';
        $audit->update();

        AuditTracking::create([
            'audit_id' => $audit->id,
            'description' => 'Complete'
        ]);

        $transaction = AuditorWalletTransaction::createTransaction($audit->auditor_id, $audit->id, $audit->payment_amount);
        
        if ($transaction) {
            $audit->is_auditor_paid = 1;
            $audit->update();
        }

        if($res){
            return back()->with(['success'=>'Report Approved Successfully']);
        }else{
            return back()->with(['error'=>'Not Approved']);
        }
    }

    public function get_specialization_auditors(Request $request){
        $audit = Audit::find($request->audit_id);
        if($audit){
            $auditors = User::whereHas('specialization', function ($query) use ($audit) {
                $query->where('certificate_id', $audit->certification_type_id);
            })->with('specialization')->get();

            return $auditors;
        }else{
            return response()->json(['massage'=>'Audit not found'], 204);
        }
    }
}
