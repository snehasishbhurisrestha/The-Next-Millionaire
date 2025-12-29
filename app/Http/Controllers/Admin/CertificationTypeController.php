<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\CertificationType;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CertificationTypeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Certification Type Show', only: ['index','show']),
            new Middleware('permission:Certification Type Create', only: ['create','store']),
            new Middleware('permission:Certification Type Edit', only: ['edit','update']),
            new Middleware('permission:Certification Type Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $items = CertificationType::all();
        return view('admin.certification-type.index',compact('items'));
    }

    public function create()
    {
        return view('admin.certification-type.create');
    }

    public function store(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = new CertificationType();
            $item->name = $request->name;
            $item->description = $request->description;
            $item->is_visible = $request->is_visible;
            if ($request->hasFile('image')) {
                $item->addMedia($request->file('image'))->toMediaCollection('certificate-image');
            }
            $res = $item->save();
            if($res){
                return back()->with('success','Added Successfully');
            }else{
                return back()->with('error','Not Added');
            }
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $item = CertificationType::findOrFail($id);
        return view('admin.certification-type.edit',compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = CertificationType::findOrFail($id);
            $item->name = $request->name;
            $item->description = $request->description;
            $item->is_visible = $request->is_visible;
            if ($request->hasFile('image')) {
                $item->clearMediaCollection('certificate-image');
                $item->addMedia($request->file('image'))->toMediaCollection('certificate-image');
            }
            $res = $item->update();

            if($res){
                return back()->with('success','Updated Successfully');
            }else{
                return back()->with('error','Not Updated');
            }
        }
    }

    public function destroy(string $id)
    {
        $item = CertificationType::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }
}
