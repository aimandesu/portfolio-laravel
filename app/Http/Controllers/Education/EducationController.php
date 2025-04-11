<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $education = Education::with('user:id,name')->get();

        return $this->showAll($education);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ((new Education)->isLocationGiven($request->input('location'))) {
            return $this->errorResponse('Location is required.', 422);
        }

        $rules = [
            // 'user_id' => 'required|exists:users,id',
            'location' => 'required|string',
            'level' => 'string|in:spm,diploma,degree,master',
            'achievement' => 'string|nullable'
        ];
    
        $this->validate($request, $rules);

        $user = Auth::user();
    
        if (!$user) {
            return $this->errorResponse('The user is not found', 409);
        }
    
        $education = Education::create([
            'user_id' => $user->id,
            'location' => $request->location,
            'level' => $request->level,
            'achievement' => $request->achievement,
        ]);
    
        return $this->showOne($education, 201);
    }    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function show(Education $education)
    {
        return $this->showOne($education, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */

     public function destroy(Education $education)
     {

         if ($education->files) {
           
             $filePath = $education->files->file;  
             
             Storage::disk('public')->delete($filePath);
         
             $education->files->delete();
         }
     
         $education->delete();
     
         return $this->showOne($education);
     }
     
     


    public function destroyEducation(Request $request)
    {
        $ids = $request->input('ids'); // Get array of IDs

        if (!is_array($ids) || empty($ids)) {
            return $this->errorResponse('No Ids Provided', 400);
        }

        // Delete records
        Education::whereIn('id', $ids)->delete();

        return $this->showMessage('Records deleted succesfully');
    }

    public function files(Education $education)
    {
        $files = $education->files;

        return $this->showOne($files, 200);
    }

    public function showAllEducationOnUserId(User $user){
        $education = Education::where('user_id', $user->id)->with('files')->get();
    
        // if ($education->isEmpty()) {
        //     return response()->json(['message' => 'No education records found for this user'], 404);
        // }
    
        return $this->showAll($education);
    }


}
