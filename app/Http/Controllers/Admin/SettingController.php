<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Setting;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use Illuminate\Support\Facades\Validator;

class SettingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:Settings Show', only: ['index']),
            new Middleware('permission:Settings Edit', only: ['update']),
        ];
    }

    public function index()
    {
        $setting = Setting::first();
        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::firstOrCreate(['id' => 1]);
        $data = $request->except(['_token', 'logo', 'favicon', 'breadcrumb_banner']);

        // ✅ Handle File Uploads
        foreach (['logo', 'favicon', 'breadcrumb_banner'] as $collection) {
            if ($request->hasFile($collection)) {
                // Remove old media in this collection
                $setting->clearMediaCollection($collection);
                // Add new one
                $setting->addMediaFromRequest($collection)->toMediaCollection($collection);
            }
        }

        $data['maintenance_mode'] = $request->has('maintenance_mode') ? 1 : 0;

        $setting->update($data);

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}