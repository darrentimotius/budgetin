<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /*
        Adriel's work field: buat 4 function
    */
    public function index() {
        $incomes =  // nanti kamu ganti ini ya el
        confirmDelete('Are you sure you want to delete this income?');
        return view('pages.transaction.income', ['title' => 'Income'], compact('incomes'));
    }
}
