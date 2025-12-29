<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Lead;
use App\Models\FollowUp;
use App\Models\BusinessCategory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Imports\LeadsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LeadController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Lead Show', only: ['index','new_leades','show']),
            new Middleware('permission:Lead Create', only: ['create','store','lead_import','import_lead_page']),
            new Middleware('permission:Lead Edit', only: ['edit','update']),
            new Middleware('permission:Lead Delete', only: ['destroy']),
            new Middleware('permission:Lead Followup', only: ['add_followup_status']),
        ];
    }

    public function index() //all leades
    {
        $items = Lead::all();
        return view('admin.lead.index',compact('items'));
    }

    public function new_leades()
    {
        $items = Lead::where('status','new')->get();
        return view('admin.lead.index',compact('items'));
    }

    public function create()
    {
        $business_categorys = BusinessCategory::where('is_visible',1)->get();
        return view('admin.lead.create',compact('business_categorys'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'business_name' => 'required|max:255',
            'business_category_id' => 'required|exists:business_categories,id',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|regex:/^[6789]/|unique:users,phone',
            'opt_mobile_no' => 'nullable|digits:10|regex:/^[6789]/',
            'remarks' => 'nullable',
            'next_follow_up_date' => 'nullable|date|after:today',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $lead = new Lead();
            $lead->first_name = $request->first_name;
            $lead->last_name = $request->last_name;
            $lead->business_name = $request->business_name;
            $lead->business_category_id = $request->business_category_id;
            $lead->email = $request->email;
            $lead->gender = $request->gender;
            $lead->phone = $request->phone;
            $lead->opt_mobile_no = $request->opt_mobile_no;
            $lead->contact_person = $request->contact_person;
            $lead->address = $request->address;
            $lead->business_address = $request->business_address;
            $lead->status = 'new';
            $res = $lead->save();

            if(isset($request->remarks) || isset($request->next_follow_up_date)){
                $followup = new FollowUp();
                $followup->lead_id = $lead->id;
                $followup->next_follow_up_date = format_date_for_db($request->next_follow_up_date);
                $followup->remarks = $request->remarks;
                $followup->save();

                $lead->status = 'in progress';
                $res = $lead->update();
            }

            if($res){
                return back()->with('success','Lead Added Successfully');
            }else{
                return back()->with('error','Lead Not Added');
            }
        }
    }

    public function show(string $id)
    {
        $item = Lead::findOrFail($id);
        $followups = $item->followUps;
        return view('admin.lead.show',compact('item','followups'));
    }

    public function edit(string $id)
    {
        $business_categorys = BusinessCategory::where('is_visible',1)->get();
        $item = Lead::findOrFail($id);
        return view('admin.lead.edit',compact('business_categorys','item'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'business_name' => 'required|max:255',
            'business_category_id' => 'required|exists:business_categories,id',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|regex:/^[6789]/|unique:users,phone',
            'opt_mobile_no' => 'nullable|digits:10|regex:/^[6789]/',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $lead = Lead::findOrFail($id);
            $lead->first_name = $request->first_name;
            $lead->last_name = $request->last_name;
            $lead->business_name = $request->business_name;
            $lead->business_category_id = $request->business_category_id;
            $lead->email = $request->email;
            $lead->gender = $request->gender;
            $lead->phone = $request->phone;
            $lead->opt_mobile_no = $request->opt_mobile_no;
            $lead->contact_person = $request->contact_person;
            $lead->address = $request->address;
            $lead->business_address = $request->business_address;
            $res = $lead->update();

            if($res){
                return back()->with('success','Lead updated Successfully');
            }else{
                return back()->with('error','Lead Not updated');
            }
        }
    }

    public function destroy(string $id)
    {
        $item = Lead::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }

    public function add_followup_status(Request $request){
        $validator = Validator::make($request->all(), [
            'inquiry_id' => 'required|exists:leads,id',
            'remarks' => 'required',
            'next_followup_date' => 'nullable|date|after:today',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $followup = new FollowUp();
            $followup->lead_id = $request->inquiry_id;
            $followup->next_follow_up_date = format_date_for_db($request->next_followup_date);
            $followup->remarks = $request->remarks;
            $followup->remarked_by = Auth::id();
            $res = $followup->save();

            $lead = Lead::findOrFail($request->inquiry_id);
            $lead->status = $request->status;
            $lead->update();

            if($res){
                return back()->with('success','Lead Added Successfully');
            }else{
                return back()->with('error','Lead Not Added');
            }
        }
    }

    public function import_lead_page(Request $request)
    {
        return view('admin.lead.import');
    }

    public function lead_import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new LeadsImport, $request->file('file'));
            return redirect()->back()->with('success', 'Leads imported successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }
}
