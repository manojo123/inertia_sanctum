<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class TokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return Inertia::render('Dashboard', [
            'tokens' => auth()->user()->tokens,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'token_name' => 'required|min:4',
        ]);

        $token = $request->user()->createToken($request->token_name);

        return Inertia::render('Profile/Edit', [
            'plainTextToken' => $token->plainTextToken,
            'token' => $token,
        ]);
    }

    public function destroy($token_id)
    {

        auth()
            ->user()
            ->tokens()
            ->where('id', $token_id)
            ->delete();

            Redirect::route('profile.edit');
    }
}
