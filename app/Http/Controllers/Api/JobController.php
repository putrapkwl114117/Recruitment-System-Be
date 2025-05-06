<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
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
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'salary' => 'required|numeric',
        'category' => 'required|string',
        'location' => 'required|string',
        'type' => 'required|string',
        'experience_level' => 'required|in:Junior,Middle,Senior',
        'skills' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Lengkapi Data Lowongan',
            'errors' => $validator->errors(),
        ], 422);
    }

    $data = $validator->validated();

    // Upload image jika ada
     if ($request->hasFile('image')) {
        $image = $request->file('image');
        $path = $image->store('jobs', 'public');
        $data['image'] = 'storage/' . $path;
    }

    $job = Job::create($data);

    return response()->json([
        'message' => 'Job created successfully',
        'job' => $job,
    ], 201);
}


    public function allJobs()
    {
        $jobs = Job::all(); 
        return response()->json($jobs);
    }

    public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'salary' => 'required|numeric',
        'category' => 'required|string',
        'location' => 'required|string',
        'type' => 'required|string',
        'experience_level' => 'required|in:Junior,Middle,Senior',
        'skills' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Lengkapi Data Lowongan',
            'errors' => $validator->errors(),
        ], 422);
    }

    $data = $validator->validated();

    // Handle upload image jika ada
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $path = $image->store('jobs', 'public');
        $data['image'] = 'storage/' . $path;
    }

    $job = Job::findOrFail($id);
    $job->update($data);

    return response()->json([
        'message' => 'Job updated successfully',
        'job' => $job,
    ], 200);
}


    public function destroy($id)
    {
        $job = Job::findOrFail($id);
        $job->delete();

        return response()->json([
            'message' => 'Job deleted successfully',
        ], 200);
    }
}