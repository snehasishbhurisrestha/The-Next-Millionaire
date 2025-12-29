<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use Illuminate\Support\Facades\Validator;

use App\Models\InspectionItem;

class ChecklistItemController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Checklist Item Show', only: ['index','show']),
            new Middleware('permission:Checklist Item Create', only: ['create','store']),
            new Middleware('permission:Checklist Item Edit', only: ['edit','update']),
            new Middleware('permission:Checklist Item Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inspection_category_id' => 'required|exists:inspection_categories,id',
            'name' => 'required|max:255',
            'point' => 'required',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = new InspectionItem();
            $item->inspection_category_id = $request->inspection_category_id;
            $item->name = $request->name;
            $item->point = $request->point;
            $item->is_visible = $request->is_visible;
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
        
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'inspection_item_id' => 'required|exists:inspection_items,id',
            'name' => 'required|max:255',
            'point' => 'required',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = InspectionItem::findOrFail($id);
            $item->name = $request->name;
            $item->point = $request->point;
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
        $item = InspectionItem::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }
}
