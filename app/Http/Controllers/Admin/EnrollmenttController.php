<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmenttController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with('user','course')
            ->latest()
            ->get();

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function show($id)
    {
        $enrollment = Enrollment::with('user','course')->findOrFail($id);
        return view('admin.enrollments.show', compact('enrollment'));
    }
}
