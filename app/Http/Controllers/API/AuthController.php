<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Inserisci la tua e-mail',
            'email.email' => 'Inserisci una e-mail valida',
            'password.required' => 'Inserisci una password',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }


        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::guard('web')->user();

            $success['token'] = $user->createToken('app')->accessToken;

            return response()->json($success);
        } else {
            return response()->json(['error' => 'Login non valido. Riprova.'], 422);
        }
    }
}
