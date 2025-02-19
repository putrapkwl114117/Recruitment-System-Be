<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // Menampilkan daftar pekerjaan
    public function index()
    {
        $jobs = Job::all();
        return response()->json($jobs);
    }
    public function show($id)
    {
        $job = Job::findOrFail($id);
        return response()->json($job);
    }

    // Menambahkan pekerjaan baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|numeric',
            'category' => 'required|string',
            'location' => 'required|string',
        ]);
        $job = Job::create([
            'title' => $request->title,
            'description' => $request->description,
            'salary' => $request->salary,
            'category' => $request->category,
            'location' => $request->location,
            'user_id' => Auth::id(), 
        ]);
        return response()->json([
            'message' => 'Job created successfully',
            'job' => $job,
        ], 201);
    }

    // Mengupdate pekerjaan yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'salary' => 'required|numeric',
            'category' => 'required|string',
            'location' => 'required|string',
        ]);
        $job = Job::findOrFail($id);
        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'salary' => $request->salary,
            'category' => $request->category,
            'location' => $request->location,
        ]);
        return response()->json([
            'message' => 'Job updated successfully',
            'job' => $job,
        ], 200);
    }
    // Menghapus pekerjaan
    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();
        return response()->json([
            'message' => 'Job deleted successfully',
        ], 200);
    }
}