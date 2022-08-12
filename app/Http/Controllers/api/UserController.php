<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function show()
    {
        return new UserResource(Auth::user());
    }

    public function update(Request $request)
    {
        // $this
        //     ->option('name', 'required|string|max:50')
        //     ->option('job_title', 'required|string|max:20')
        //     ->option('email', 'required|email')
        //     ->option('mobile_no', 'required|string|max:14')
        //     ->option('location', 'required|string')
        //     ->verify();

        $user = Auth::user();

        $user->update($request->only('name', 'email', 'mobile_no', 'job_title', 'github_profile', 'linkedin_profile', 'location'));

        return new UserResource($user);
    }

    public function destroy()
    {
        Auth::user()->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
