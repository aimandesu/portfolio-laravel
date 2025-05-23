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
            'name' => 'required|string',
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
    public function show(string $username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return $this->errorResponse("User with username '{$username}' not found.", 404);
        }

        return $this->showOne($user);
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
        if ($user->isEmailAlreadyUsed($request->email)) {
            return $this->errorResponse('Email already in use', 422);
        }

        if ($user->isUsernameAlreadyUsed($request->username)) {
            return $this->errorResponse('Username already in use', 422);
        }

        if (empty($request->title)) {
            return $this->errorResponse('Title is empty', 422);
        }        

        // if (!$request->filled('title')) {
        //     return $this->errorResponse('Title is empty', 422);
        // }
        

        $rules = [
            'username' => 'required|string|alpha_dash|unique:users,username,'.$user->id, //now can use without_spaces, check AppServiceProvider.php
            'name' => 'required|string',
            'age' => 'nullable|string',
            'title' => 'required|string',
            'about' => 'nullable|string',
            'location' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'required|string|email|unique:users,email,'.$user->id,
        ];

        $request->validate($rules);

        $user->fill($request->only([
            'username',
            'name', 
            'age',
            'title', 
            'about', 
            'location', 
            'address', 
            'email',
        ]));

        // if (!$user->isDirty()) {
        //     return $this->errorResponse('You need to specify a different value to update', 422);
        // }

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
            $user->image = $imagePath;
            $user->save();

            return $this->showOne($user, 201);

        } else {
            return $this->errorResponse(`The image for user $user->id is not available`, 409);
        }
    }

    public function uploadResume(User $user, Request $request)
    {
        $rules = [
            'resume' => 'required|mimes:pdf|max:2048',
        ];

        $this->validate($request, $rules);

        if($request->hasFile('resume')){

            if($user->resume){
                 // Delete the old file from storage
                Storage::disk('public')->delete($user->resume);
            }

            $resume = $request->file('resume');
            $resumePath = $resume->store('resume', 'public');

            $user->resume = $resumePath;
            $user->save();

            return $this->showOne($user, 201);
        
        }

    }

}
