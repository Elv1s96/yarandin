<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    public function getUsers()
    {
        $users = DB::table('users')->get();
        return view('admin.adminUsers',compact('users'));
    }
}
