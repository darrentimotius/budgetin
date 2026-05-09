<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index() {
        confirmDelete('Are you sure want to delete this account?');
        return(view('pages.user.settings', ['title' => 'Settings']));
    }
}
