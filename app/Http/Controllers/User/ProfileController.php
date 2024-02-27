<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    function show_profile() {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        return response()->json($user);
    }
}
