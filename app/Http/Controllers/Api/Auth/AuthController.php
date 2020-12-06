<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->errors()
            ], 422);
        }

        $input = $request->all();

        $input['password'] = Hash::make($input['password']);

        /**
         * @var User
         */
        $user = User::create($input);

        return response()->json([
            'success' => true,
            'message' => __('messages.user.created'),
            'data' => [
                'email' => $user->email,
                'name' => $user->name
            ]
        ], 201);
    }
}
