<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;


class ResetPasswordController extends Controller
{
    public function index() {
        return view('pages.auth.reset');
    }
}
