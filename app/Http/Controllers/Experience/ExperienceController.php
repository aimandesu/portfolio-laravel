<?php

namespace App\Http\Controllers\Experience;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use ExperienceType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $experience = Experience::with('user:id,name')->get();
        
        return response()->json($experience, 200);
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
            'title' => 'string|required',
            'location' => 'string|required',
            'description' => 'nullable|string'
        ];

        $this->validate($request, $rules);

        $user = Auth::user();
    
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $experience = Experience::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'location' => $request->location,
            'description' => $request->description,
        ]);
    
        return response()->json(['message' => 'Record stored successfully', 'data' => $experience], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function show(Experience $experience)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experience $experience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        $experience->delete();

        return response()->json($experience, 200);
    }

    public function getExperienceAvailable(){
        $experience = config('custom.experience_available');
        // $experiences = array_column(ExperienceType::cases(), 'value');
        
        return response()->json($experience, 200);
    }

}
