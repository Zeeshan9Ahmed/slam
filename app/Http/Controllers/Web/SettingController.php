<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function setting()
    {
        $user = User::with('venue')->whereId(auth()->id())->first();
        // dd($user);

        // return $user;
        return view('web.settings.index', compact('user'));
    }
}
