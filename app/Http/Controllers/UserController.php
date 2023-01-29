<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //

    public function create(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user)->setStatusCode(201);
    }

    public function update(Request $request,  $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json($user)->setStatusCode(201);

    }

    public function show(Request $request,  $id)
    {
        $user = User::find($id);
        return $user ?  response()->json($user) : response()->json(['error'=>'user not found'])->setStatusCode(404) ;

    }

    public function destroy(Request $request,  $id)
    {
        User::destroy($id);
        return response()->json()->setStatusCode(204);

    }

    public function index(Request $request)
    {
        return response()->json(User::all());

    }

}
