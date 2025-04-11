<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\User;
use Illuminate\Http\Request;
use ProjectType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::with('user:id,name')->get();

        return $this->showAll($project);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $rules = [
            'type' => ['required', new Enum(ProjectType::class)],
            'title' => 'required|string',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file types and size as needed
        ];
        
        $this->validate($request, $rules);
        
        // Create project
        $project = Project::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        
        // Handle images if provided
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Generate unique filename
                $filename = time() . '_' . $image->getClientOriginalName();
                
                // Store the file in storage/app/public/images
                // Make sure you have run: php artisan storage:link
                $path = $image->storeAs('images', $filename, 'public');
                
                // Create image record in database
                $project->images()->create([
                    'image' => $path
                ]);
            }
        }
        
        // Load the images relationship before returning
        $project->load('images');
        
        return $this->showOne($project, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

   
    public function updateProject(Request $request, Project $project)
    {
        $rules = [
            'type' => ['required', new Enum(ProjectType::class)],
            'title' => 'string',
            'description' => 'string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'deleted_images_id' => 'nullable|array',
            'deleted_images_id.*' => 'numeric' // Use numeric instead of number
        ];
    
        $request->validate($rules);
    
        // Update project details
        if($request->has('type')){
            $project->type = $request->type;
        }
        
        if ($request->has('title')) {
            $project->title = $request->title;
        }
    
        if ($request->has('description')) {
            $project->description = $request->description;
        }
    
        $project->save();
    
        // Handle image deletions
        if ($request->has('deleted_images_id') && !empty($request->deleted_images_id)) {
            foreach ($request->deleted_images_id as $imageId) {
                $imageToDelete = ProjectImage::find($imageId);
            
                if ($imageToDelete && $imageToDelete->project_id == $project->id) {
                    Storage::disk('public')->delete($imageToDelete->image);
                    $imageToDelete->delete();
                }
            }
        }
    
        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs('images', $filename, 'public');
            
                $project->images()->create([
                    'image' => $path
                ]);
            }
        }
    
        $project->load('images');
        return $this->showOne($project, 200); // Use 200 for updates, not 201
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        // Get all images before deleting them
        $images = $project->images;
    
        // Delete the image files and records
        foreach ($images as $image) {
            // Delete file from storage
            Storage::disk('public')->delete($image->image);
        
            // Delete the database record
            $image->delete();
        }
    
        // Delete the project itself
        $project->delete();
    
        return $this->showOne($project);

    }

    public function showAllProjectOnUserId(User $user)
    {
        $projects = Project::where('user_id', $user->id)->with('images')->get();
   
        return $this->showAll($projects);
    }

}
