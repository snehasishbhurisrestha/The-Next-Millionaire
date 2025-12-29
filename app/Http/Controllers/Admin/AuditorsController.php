<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\CertificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuditorsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Auditor Show', only: ['index','show']),
            new Middleware('permission:Auditor Create', only: ['create','store']),
            new Middleware('permission:Auditor Edit', only: ['edit','update']),
            new Middleware('permission:Auditor Delete', only: ['destroy']),
        ];
    }

    public function index(){
        // $auditors = User::role('auditor')->get();
        $auditors = User::role('auditor')->with('specialization')->get();
        return view('admin.auditors.index',compact('auditors'));
    }

    public function create(){
        $certification_types = CertificationType::where('is_visible',1)->get();
        return view('admin.auditors.create',compact('certification_types'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|regex:/^[6789]/|unique:users,phone',
            'aadhaar_number' => 'nullable|digits:12|unique:users,aadhar_card_number',
            'pan_card_number' => 'nullable|regex:/[A-Z]{5}[0-9]{4}[A-Z]{1}/|unique:users,pan_card_number',
            'password' => 'required|min:8',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'aadhar_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pan_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:1,0'
        ], [
            'profile_image.max' => 'The Profile Image must not be larger than 2 MB.',
            'aadhar_image.max' => 'The Aadhar Image must not be larger than 2 MB.',
            'pan_image.max' => 'The Pan Image must not be larger than 2 MB.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $auditor = new User();
            $auditor->status = $request->status;
            $auditor->user_id = generateUniqueId('auditor');
            $auditor->first_name = $request->first_name;
            $auditor->last_name = $request->last_name;
            $auditor->name = $request->first_name.' '.$request->last_name;
            $auditor->date_of_birth = format_date_for_db($request->date_of_birth);
            $auditor->gender = $request->gender;
            $auditor->address = $request->address;
            $auditor->email = $request->email;
            $auditor->phone = $request->phone;
            $auditor->opt_mobile_no = $request->opt_mobile_no;
            $auditor->password = bcrypt($request->password);
            $auditor->aadhar_card_number = $request->aadhaar_number;
            $auditor->pan_card_number = $request->pan_card_number;
            $auditor->bank_name = $request->bank_name;
            $auditor->branch_name = $request->branch_name;
            $auditor->account_number = $request->account_number;
            $auditor->ifsc_code = $request->ifsc_code;

            if ($request->hasFile('profile_image')) {
                $auditor->addMedia($request->file('profile_image'))->toMediaCollection('auditors-image');
            }

            if ($request->hasFile('aadhar_image')) {
                $auditor->addMedia($request->file('aadhar_image'))->toMediaCollection('auditors-aadhar');
            }

            if ($request->hasFile('pan_image')) {
                $auditor->addMedia($request->file('pan_image'))->toMediaCollection('auditors-pan');
            }

            $auditor->syncRoles('Auditor');
            $res = $auditor->save();

            if ($request->has('specialization')) {  
                $auditor->specialization()->sync($request->specialization);
            }

            if($res){
                return back()->with('success','Auditor Added Successfully');
            }else{
                return back()->with('success','Auditor Not Added');
            }
        }
    }

    public function show(string $id)
    {
        $auditor = User::findOrFail($id);
        return view('admin.auditors.show',compact('auditor'));
    }

    public function edit(string $id)
    {
        // $auditor = User::findOrFail($id);
        $certification_types = CertificationType::where('is_visible',1)->get();
        $auditor = User::with('specialization')->findOrFail($id); // Fetch user and their certifications
        return view('admin.auditors.edit',compact('auditor','certification_types'));
    }

    public function update(Request $request, string $id)
    {
        $auditor = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'email' => 'required|email|unique:users,email,'. $auditor->id,
            'phone' => 'required|digits:10|regex:/^[6789]/|unique:users,phone,'. $auditor->id,
            'aadhaar_number' => 'nullable|digits:12|unique:users,aadhar_card_number,'. $auditor->id,
            'pan_card_number' => 'nullable|regex:/[A-Z]{5}[0-9]{4}[A-Z]{1}/|unique:users,pan_card_number,'. $auditor->id,
            'password' => 'nullable|min:8',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'aadhar_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'pan_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:1,0'
        ], [
            'profile_image.max' => 'The Profile Image must not be larger than 2 MB.',
            'aadhar_image.max' => 'The Aadhar Image must not be larger than 2 MB.',
            'pan_image.max' => 'The Pan Image must not be larger than 2 MB.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $auditor->first_name = $request->first_name;
            $auditor->last_name = $request->last_name;
            $auditor->name = $request->first_name.' '.$request->last_name;
            $auditor->status = $request->status;
            $auditor->date_of_birth = format_date_for_db($request->date_of_birth);
            $auditor->gender = $request->gender;
            $auditor->address = $request->address;
            $auditor->email = $request->email;
            $auditor->phone = $request->phone;
            $auditor->opt_mobile_no = $request->opt_mobile_no;
            if(isset($request->password)){
                $auditor->password = bcrypt($request->password);
            }
            $auditor->aadhar_card_number = $request->aadhaar_number;
            $auditor->pan_card_number = $request->pan_card_number;
            $auditor->bank_name = $request->bank_name;
            $auditor->branch_name = $request->branch_name;
            $auditor->account_number = $request->account_number;
            $auditor->ifsc_code = $request->ifsc_code;

            if ($request->hasFile('profile_image')) {
                $auditor->clearMediaCollection('auditors-image');
                $auditor->addMedia($request->file('profile_image'))->toMediaCollection('auditors-image');
            }
        
            if ($request->hasFile('aadhar_image')) {
                $auditor->clearMediaCollection('auditors-aadhar');
                $auditor->addMedia($request->file('aadhar_image'))->toMediaCollection('auditors-aadhar');
            }
        
            if ($request->hasFile('pan_image')) {
                $auditor->clearMediaCollection('auditors-pan');
                $auditor->addMedia($request->file('pan_image'))->toMediaCollection('auditors-pan');
            }

            $res = $auditor->update();

            if ($request->has('specialization')) {  
                $auditor->specialization()->sync($request->specialization);
            }

            if($res){
                return back()->with('success','Auditor Updated Successfully');
            }else{
                return back()->with('success','Auditor Not Updated');
            }
        }
    }

    public function destroy(string $id)
    {
        $auditor = User::findOrFail($id);
        $res = $auditor->delete();
        if($res){
            return back()->with(['success'=>'Auditor Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Auditor Not Deleted']);
        }
    }

    public function id_card($id){
        $auditor = User::findOrFail($id);  
        return view('admin.auditors.id-card',compact('auditor')); 
    }
}
