<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\BusinessCategory;
use App\Models\InspectionCategory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class BusinessCategoryController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Business Category Show', only: ['index','show']),
            new Middleware('permission:Business Category Create', only: ['create','store']),
            new Middleware('permission:Business Category Edit', only: ['edit','update']),
            new Middleware('permission:Business Category Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $items = BusinessCategory::all();
        return view('admin.business-category.index',compact('items'));
    }

    public function create()
    {
        return view('admin.business-category.create');
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
            $item = new BusinessCategory();
            $item->name = $request->name;
            $item->description = $request->description;
            $item->is_visible = $request->is_visible;
            $res = $item->save();
            if($res){
                return redirect(route('business-category'))->with('success','Added Successfully');
                // return back()->with('success','Added Successfully');
            }else{
                return back()->with('error','Not Added');
            }
        }
    }

    public function show(BusinessCategory $businessCategory)
    {
        //
    }

    public function edit(string $id)
    {
        $item = BusinessCategory::findOrFail($id);
        $inspection_categorys = InspectionCategory::all();
        return view('admin.business-category.edit',compact('item','inspection_categorys'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }else{
            $item = BusinessCategory::findOrFail($id);
            $item->name = $request->name;
            $item->description = $request->description;
            $item->is_visible = $request->is_visible;
            $res = $item->update();

            if ($request->has('checklist_categories')) {
                $item->inspectionCategories()->sync($request->checklist_categories);
            }

            if($res){
                return back()->with('success','Updated Successfully');
            }else{
                return back()->with('error','Not Updated');
            }
        }
    }

    public function destroy(string $id)
    {
        $item = BusinessCategory::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }
}
