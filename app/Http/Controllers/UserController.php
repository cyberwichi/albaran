<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::get();
        return $users;
    }
    public function edit(Request $request, $id)
    {
        DB::table('users')
            ->where('id', $id)
            ->update(array('name' => $request->name, 'email' => $request->email, 'email_verified_at' => $request->email_verified_at));
        return json_encode(User::get());
    }
    public function delete($id)
    {
         return User::destroy($id);
    }
}
