<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        {
        switch ($request->method()) {
            case 'GET':
                if ($id = $request->route('id')) {
                    return User::findOrFail($id);
                }
                return User::paginate(10);

            case 'POST':
                $data = $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                ]);
                return response()->json(User::create($data), 201);

            case 'PUT':
                $id = $request->route('id');
                $user = User::findOrFail($id);
                $data = $request->validate([
                    'name' => 'sometimes|string|max:255',
                    'email' => "sometimes|email|unique:users,email,{$id}",
                ]);
                $user->update($data);
                return $user;

            case 'DELETE':
                $id = $request->route('id');
                $user = User::findOrFail($id);
                $user->delete();
                return response()->noContent();

            default:
                abort(405);
        }
    }
    }
}
