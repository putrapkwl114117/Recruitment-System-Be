<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Job;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'job_id' => 'required|exists:jobs,id',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'experience' => 'nullable|string',
            'cv' => 'required|file|mimes:pdf|max:2048',
            'portfolio' => 'nullable|file|max:4096',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->has('cv') 
                    ? 'Format CV Tidak Valid' 
                    : 'Lengkapi Data Anda',
                'errors' => $validator->errors(),
            ], 422);
        }

        $cvPath = $request->file('cv')->store('applications/cv', 'public');
        $portfolioPath = $request->hasFile('portfolio') 
            ? $request->file('portfolio')->store('applications/portfolio', 'public') 
            : null;

        $application = Application::create([
            'job_id' => $request->job_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'experience' => $request->experience,
            'cv' => $cvPath,
            'portfolio' => $portfolioPath,
        ]);

        return response()->json([
            'message' => 'Lamaran berhasil dikirim',
            'application' => $application,
        ], 201);
    }
    

    public function index()
{
    $applications = Application::with('job')->latest()->get();

    return response()->json([
        'message' => 'Semua data pelamar berhasil diambil',
        'applications' => $applications,
    ], 200);
}


public function getByJob($jobId)
{
    $applications = Application::where('job_id', $jobId)->with('job')->get();

    return response()->json([
        'message' => "Daftar pelamar untuk job ID: $jobId",
        'applications' => $applications,
    ], 200);
}


public function destroy($id)
{
    $application = Application::findOrFail($id);

    // Hapus file CV dan portofolio jika ada
    if ($application->cv && \Storage::disk('public')->exists($application->cv)) {
        \Storage::disk('public')->delete($application->cv);
    }

    if ($application->portfolio && \Storage::disk('public')->exists($application->portfolio)) {
        \Storage::disk('public')->delete($application->portfolio);
    }

    $application->delete();

    return response()->json([
        'message' => 'Lamaran berhasil dihapus',
    ], 200);
}


}