<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the users.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $users = User::all();
        return Inertia::render('Users', ['users' => $users]);
    }
     /**
     * Show the profile for the authenticated user.
     *
     * @return \Inertia\Response
     */
    public function profile()
    {
        $user = auth()->user();
        return Inertia::render('Profile', ['user' => $user]);
    }
}
