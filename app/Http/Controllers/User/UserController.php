<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];
   
        $validatedData = $request->validate($rules);
   
        $validatedData['password'] = bcrypt($validatedData['password']);
   
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password'],
        ]);
   
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
    
        $rules = [
            'name' => 'required',
            'title' => 'required',
            'location' => 'required',
            'address' => 'required',
            'email' => 'required',
        ];

        $request->validate($rules);

        $user->fill($request->only([
            'name', 
            'title', 
            'location', 
            'address', 
            'email',
        ],),);

        if (!$user->isDirty()) {
            return response()->json(['error' => 'You need to specify a different value to update', 'code' => 422], 422);
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully', 'data' => $user], 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        
    }


    public function uploadImage(User $user, Request $request)
    {
        $rules = [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        $this->validate($request, $rules);

        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            // Upload new image to storage/app/public/image
            $image = $request->file('image');
            $imagePath = $image->store('image', 'public'); // 'image' folder inside storage/app/public

            // Save the relative path like 'image/filename.jpg'
            $user->image = 'http://127.0.0.1:8000/storage/' . $imagePath;
            $user->save();

            return response()->json([
                'message' => 'User image updated successfully',
                'image_url' => 'http://127.0.0.1:8000' . Storage::url($imagePath) // This gives you /storage/image/filename.jpg
            ]);
        } else {
            return response()->json(['error' => 'No image found'], 400);
        }
    }

}
