<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\InspectionCategory;
use App\Models\InspectionItem;

use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ChecklistCategorieController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Checklist Categorie Show', only: ['index','show']),
            new Middleware('permission:Checklist Categorie Create', only: ['create','store']),
            new Middleware('permission:Checklist Categorie Edit', only: ['edit','update']),
            new Middleware('permission:Checklist Categorie Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $items = InspectionCategory::all();
        return view('admin.checklist_categorie.index',compact('items'));
    }

    public function create()
    {
        return view('admin.checklist_categorie.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'max_score' => 'required',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = new InspectionCategory();
            $item->name = $request->name;
            $item->max_score = $request->max_score;
            $item->is_visible = $request->is_visible;
            $res = $item->save();
            if($res){
                return redirect(route('checklist-categorie.edit',$item->id))->with('success','Added Successfully');
                // return back()->with('success','Added Successfully');
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
        $item = InspectionCategory::findOrFail($id);
        $inspection_items = InspectionItem::where('inspection_category_id',$id)->get();
        
        return view('admin.checklist_categorie.edit',compact('item','inspection_items'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'max_score' => 'required',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = InspectionCategory::findOrFail($id);
            $item->name = $request->name;
            $item->max_score = $request->max_score;
            $item->is_visible = $request->is_visible;
            $res = $item->update();
            if($res){
                return back()->with('success','Updated Successfully');
            }else{
                return back()->with('error','Not Added');
            }
        }
    }

    public function destroy(string $id)
    {
        $item = InspectionCategory::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }
}
