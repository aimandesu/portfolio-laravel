<?php

namespace App\Http\Controllers\Education;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return response()->json($education, 200);
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
            // 'user_id' => 'required|exists:users,id',
            'location' => 'required',
            'level' => 'in:diploma,degree',
            'achievement' => 'nullable'
        ];
    
        $this->validate($request, $rules);

        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        $education = Education::create([
            'user_id' => $user->id,
            'location' => $request->location,
            'level' => $request->level,
            'achievement' => $request->achievement,
        ]);
    
        return response()->json(['message' => 'Record stored successfully', 'data' => $education], 201);
    }    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // Get education records where user_id matches the given user ID
        $education = Education::where('user_id', $user->id)->get();
    
        if ($education->isEmpty()) {
            return response()->json(['message' => 'No education records found for this user'], 404);
        }
    
        return response()->json($education, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function edit(Education $education)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Education $education)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Http\Response
     */
    public function destroyEducation(Request $request)
    {
        $ids = $request->input('ids'); // Get array of IDs

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No IDs provided'], 400);
        }

        // Delete records
        Education::whereIn('id', $ids)->delete();

        return response()->json(['message' => 'Records deleted successfully'], 200);
    }

}
