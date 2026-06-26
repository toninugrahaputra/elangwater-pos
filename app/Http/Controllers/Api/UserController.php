<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Get the authenticated user.
     */
    public function me()
    {
        $user = auth()->user()->load(['roles', 'permissions']);

        return response()->json($user);
    }
}