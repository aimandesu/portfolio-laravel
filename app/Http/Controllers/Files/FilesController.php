<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Files;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = Files::with('education:id,user_id')->get();

        return response()->json($files, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'education_id' => 'required|exists:education,id',
            'file' => 'required|mimes:pdf|max:2048',
            'description' => 'nullable|string',
        ]);

        // Ensure the education record belongs to the authenticated user
        $education = Education::where('id', $request->education_id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$education) {
            return response()->json(['message' => 'Unauthorized: This education record does not belong to you.'], 403);
        }

        $existingFile = Files::where('education_id', $request->education_id)->first();

        if ($existingFile) {
            // Delete the old file from storage
            Storage::disk('public')->delete($existingFile->file);
    
            // Update the existing file record
            $existingFile->update([
                'description' => $request->description,
                'file' => $request->file('file')->store('pdfs', 'public'),
            ]);
    
            return response()->json([
                'message' => 'File updated successfully',
                'file' => $existingFile,
            ], 200);
        }

        $file = Files::create([
            'education_id' => $request->education_id,
            'description' => $request->description,
            'file' => $request->file('file')->store('pdfs', 'public'),
        ]);
    
        return response()->json([
            'message' => 'File uploaded successfully',
            'file' => $file,
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function show(Files $files)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function edit(Files $files)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Files $files)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function destroy(Files $file)
    {
        Storage::disk('public')->delete($file->file);
        
        $file->delete();

        return response()->json($file, 200);
    }

}
