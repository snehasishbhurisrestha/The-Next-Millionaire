<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Update;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class NewUpdateController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:New Update Show', only: ['index','show']),
            new Middleware('permission:New Update Create', only: ['create','store']),
            new Middleware('permission:New Update Edit', only: ['edit','update']),
            new Middleware('permission:New Update Delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $items = Update::all();
        return view('admin.new_updates.index',compact('items'));
    }

    public function create()
    {
        return view('admin.new_updates.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = new Update();
            $item->description = $request->description;
            $item->is_visible = $request->is_visible;
            $res = $item->save();
            if($res){
                return back()->with('success','Added Successfully');
            }else{
                return back()->with('error','Not Added');
            }
        }
    }

    public function show(Update $Update)
    {
        //
    }

    public function edit(string $id)
    {
        $item = Update::findOrFail($id);
        return view('admin.new_updates.edit',compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'is_visible' => 'required|in:1,0'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $item = Update::findOrFail($id);
            $item->description = $request->description;
            $item->is_visible = $request->is_visible;
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
        $item = Update::findOrFail($id);
        $res = $item->delete();
        if($res){
            return back()->with(['success'=>'Deleted Successfully']);
        }else{
            return back()->with(['error'=>'Not Deleted']);
        }
    }
}
