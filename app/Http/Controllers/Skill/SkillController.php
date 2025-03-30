<?php

namespace App\Http\Controllers\Skill;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skill = Skill::all();
        return response()->json($skill, 200);
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
            'name' => 'required|string',
            'description' => 'nullable|string'
        ];

        $this->validate($request, $rules);

        $skill = Skill::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Skill stored successfully', 'data' => $skill], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $skill = Skill::where('user_id', $user->id)->get();

        
        if ($skill->isEmpty()) {
            return response()->json(['message' => 'No skill records found for this user'], 404);
        }
    
        return response()->json($skill, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Skill  $skill
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        return response()->json($skill, 200);
    }
}
