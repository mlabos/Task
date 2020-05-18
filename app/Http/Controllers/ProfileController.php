<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Profile;
use App\Http\Resources\Profile as ProfileResource;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profiles = Profile::orderBy('created_at', 'desc')->paginate(10);

        return ProfileResource::collection($profiles);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $profile = $request->isMethod('put') ? Profile::findOrFail
        ($request->profile_id): new Profile;

        $profile->id = $request->input('profile_id');
        $profile->first_name = $request->input('first_name');
        $profile->last_name = $request->input('last_name');
        $profile->course = $request->input('course');

        if($profile->save()) {
            return new ProfileResource($profile);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = Profile::findOrFail($id);

        return new ProfileResource($profile);
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        
        if($profile->delete()) {
            return new ProfileResource($profile);
        }
        
    }
}
