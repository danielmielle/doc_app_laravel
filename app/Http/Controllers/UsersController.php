<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function login(Request $request)
    {
       //validate incoming inputs
       $request->validate([
           'email'=>'required|email',
           'password'=>'required',
       ]);

       //check matching user
       $user = User::where('email', $request->email)->first();

       //check password
       if(!$user || ! Hash::check($request->password, $user->password)){
           throw ValidationException::withMessages([
               'email'=>['The provided credentials are incorrect'],
           ]);
       }

       //then return generated token
       return $user->createToken($request->email)->plainTextToken;
    }

    public function register(Request $request)
        {
            //validate incoming inputs
            $request->validate([
                'name'=>'required|string',
                'email'=>'required|email',
                'password'=>'required',
            ]);

            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'type'=>'user',
                'password'=>Hash::make($request->password),
            ]);

            $userInfo = UserDetails::create([
                'user_id'=>$user->id,
                'status'=>'active',
            ]);

            return $user;


        }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
