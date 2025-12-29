<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\BusinessCategory;
use App\Models\Lead;

class ContactUsController extends Controller
{
    public function index()
    {
        $business_categorys = BusinessCategory::where('is_visible',1)->get();
        return view('site.contact',compact('business_categorys'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            // 'gender' => 'required',
            // 'business_name' => 'required|max:255',
            // 'business_category_id' => 'required|exists:business_categories,id',
            'email' => 'required|email',
            // 'phone' => 'required|digits:10|regex:/^[6789]/',
            // 'opt_mobile_no' => 'nullable|digits:10|regex:/^[6789]/',
            'message' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $lead = new Lead();

            $name = splitName($request->name);

            $lead->first_name = $name['first_name'];
            $lead->last_name = $name['last_name'];
            $lead->business_name = $request->business_name;
            $lead->business_category_id = $request->business_category_id;
            $lead->email = $request->email;
            $lead->gender = $request->gender ?? 'others';
            $lead->phone = $request->phone;
            // $lead->opt_mobile_no = $request->opt_mobile_no;
            // $lead->contact_person = $request->contact_person;
            $lead->address = $request->address;
            $lead->business_address = $request->business_address;
            $lead->message = $request->message;
            $lead->status = 'new';
            $res = $lead->save();

            if($res){
                return back()->with('success','Thank you for reaching out! Your message has been successfully submitted. Our team will review your request and get back to you as soon as possible. We look forward to connecting with you soon!');
            }else{
                return back()->with('error','Please try again');
            }
        }
    }
}
