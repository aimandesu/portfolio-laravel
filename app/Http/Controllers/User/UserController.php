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
        return $this->showAll($users);
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
   
        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user, 201);
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
            'name' => 'required|string',
            'title' => 'required|string',
            'about' => 'nullable|string',
            'location' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'required|string',
        ];

        $request->validate($rules);

        $user->fill($request->only([
            'name', 
            'title', 
            'about', 
            'location', 
            'address', 
            'email',
        ]));

        if (!$user->isDirty()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $user->save();

        return $this->showOne($user);
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

            return $this->showOne($user, 201);

            // return response()->json([
            //     'message' => 'User image updated successfully',
            //     'image_url' => 'http://127.0.0.1:8000' . Storage::url($imagePath) // This gives you /storage/image/filename.jpg
            // ]);
        } else {
            return $this->errorResponse(`The image for user $user->id is not available`, 409);
        }
    }

}
