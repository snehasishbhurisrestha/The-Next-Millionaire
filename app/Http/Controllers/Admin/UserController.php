<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\BusinessCategory;
use App\Models\UserBusiness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Users Show', only: ['index','show']),
            new Middleware('permission:Users Create', only: ['create','store']),
            new Middleware('permission:Users Edit', only: ['edit','update']),
            new Middleware('permission:Users Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $users = User::role('User')->get();
        return view('admin.users.index',compact('users'));
    }

    public function create()
    {
        $business_categorys = BusinessCategory::where('is_visible',1)->get();
        return view('admin.users.create',compact('business_categorys'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'business_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|digits:10|regex:/^[6789]/|unique:users,phone',
            'trade_license_number' => 'nullable',
            'password' => 'required|min:8',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'trade_license_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:1,0'
        ], [
            'profile_image.max' => 'The Profile Image must not be larger than 2 MB.',
            'trade_license_image.max' => 'The Trade License Image must not be larger than 2 MB.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $user = new User();
            $user->user_id = generateUniqueId('user');
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->name = $request->first_name.' '.$request->last_name;
            $user->status = $request->status;
            $user->date_of_birth = format_date_for_db($request->date_of_birth);
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->opt_mobile_no = $request->opt_mobile_no;
            $user->password = bcrypt($request->password);

            if ($request->hasFile('profile_image')) {
                $user->addMedia($request->file('profile_image'))->toMediaCollection('user-image');
            }

            if ($request->hasFile('trade_license_image')) {
                $user->addMedia($request->file('trade_license_image'))->toMediaCollection('user-trade-licence');
            }

            $user->syncRoles('User');
            $res = $user->save();

            $user_business = UserBusiness::create([
                'user_id' => $user->id,
                'business_name' => $request->business_name,
                'business_category_id' => $request->business_category,
                'trade_license_number' => $request->trade_license_number,
                'business_address' => $request->business_address
            ]);

            if($res){
                return back()->with('success','User Added Successfully');
            }else{
                return back()->with('success','User Not Added');
            }
        }
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show',compact('user'));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $business_categorys = BusinessCategory::where('is_visible',1)->get();
        return view('admin.users.edit',compact('user','business_categorys'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'last_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'business_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'. $user->id,
            'phone' => 'required|digits:10|regex:/^[6789]/|unique:users,phone,'. $user->id,
            'trade_license_number' => 'nullable',
            'password' => 'nullable|min:8',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'trade_license_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:1,0'
        ], [
            'profile_image.max' => 'The Profile Image must not be larger than 2 MB.',
            'trade_license_image.max' => 'The Trade License Image must not be larger than 2 MB.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->name = $request->first_name.' '.$request->last_name;
            $user->status = $request->status;
            $user->date_of_birth = format_date_for_db($request->date_of_birth);
            $user->gender = $request->gender;
            $user->address = $request->address;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->opt_mobile_no = $request->opt_mobile_no;
            if(isset($request->password)){
                $user->password = bcrypt($request->password);
            }

            if ($request->hasFile('profile_image')) {
                $user->addMedia($request->file('profile_image'))->toMediaCollection('user-image');
            }

            if ($request->hasFile('trade_license_image')) {
                $user->addMedia($request->file('trade_license_image'))->toMediaCollection('user-trade-licence');
            }

            $res = $user->update();

            $userBusiness = UserBusiness::updateOrCreate(
                ['user_id' => $user->id], // Condition to check
                [
                    'business_name' => $request->business_name,
                    'business_category_id' => $request->business_category,
                    'trade_license_number' => $request->trade_license_number,
                    'business_address' => $request->business_address
                ]
            );

            if($res){
                return back()->with('success','User Updated Successfully');
            }else{
                return back()->with('success','User Not Updated');
            }
        }
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $res = $user->delete();
        if($res){
            return back()->with(['success'=>'User Deleted Successfully']);
        }else{
            return back()->with(['error'=>'User Not Deleted']);
        }
    }
}
