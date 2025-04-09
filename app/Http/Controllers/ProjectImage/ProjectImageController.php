<?php

namespace App\Http\Controllers\ProjectImage;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectImage = ProjectImage::all();

        return $this->showAll($projectImage);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'project_id' => 'required|exists:projects,id', // Validate project exists
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    
        $this->validate($request, $rules);
    
        // Upload and store the image
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $imagePath = $image->storeAs('images', $imageName, 'public');
    
        // Create the project image record
        $projectImage = ProjectImage::create([
            'project_id' => $request->project_id,
            'image' => $imagePath
        ]);
    
        // Return the created resource
        return $this->showOne($projectImage, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectImage  $projectImage
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectImage $projectImage)
    {
        //
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectImage  $projectImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectImage $projectImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectImage  $projectImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectImage $projectImage)
    {
        Storage::disk('public')->delete($projectImage->image);
        
        $projectImage->delete();

        return $this->showOne($projectImage, 200);
    }
}
