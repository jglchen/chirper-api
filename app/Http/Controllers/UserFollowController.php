<?php

namespace App\Http\Controllers;

use App\Models\UserFollow;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserFollowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function myfollowings(Request $request)
    {
        $followings = $request->user()->followings()->get();
        /*
        return $followings->map(function (object $item) {
            return (object)['id'=>$item->id, 'followed_id'=>$item->followed_id];
        });*/
        return $followings->map(function (object $item) {
            return $item->followed_id;
        });
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
        $validated = $request->validate([
            'followed_id' => 'required|integer',
        ]);
        
        if (User::find($validated['followed_id'])->exists()){
            $userfollow = $request->user()->followings()->create($validated);
            return response()->json([
                'status' => 'success',
            ]);
        }else{
            return response()->json([
                'status' => 'fail',
            ]);
        }
        
        /**
         * Remember add the procedures to clean related UserFollow models in
         * App\Http\Controllers\ProfileController destroy method with the user
         * deleted as the field of 'followed_id' as cascadeOnDelete effect.
         * 
         */

    }

    /**
     * Display the specified resource.
     */
    public function show(UserFollow $userFollow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserFollow $userFollow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserFollow $userFollow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $followed_id): Response
    {
        $userFollow = UserFollow::where([
            'followed_id' => $followed_id,
            'user_id' => $request->user()->id,
        ])->first();
 
        $userFollow->delete();
 
        return response()->noContent();        

    }
}
