<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index() {
        $incomes = $this->getIncome();
        confirmDelete('Are you sure you want to delete this income?');
        return view('pages.transaction.income', ['title' => 'Income'], compact('incomes'));
    }

    public function getIncome() {
        return [
            (object) [
                'id' => 1,
                'title' => 'Gajian',
                'amount' => 5000000,
                'account_bank' => 'BCA',
                'date' => '2025-06-01',
                'description' => 'gaji bulanan',
            ],
            (object) [
                'id' => 2,
                'title' => 'Gajian',
                'amount' => 5000000,
                'account_bank' => 'BCA',
                'date' => '2025-06-01',
                'description' => 'gaji bulanan',
            ],
            (object) [
                'id' => 3,
                'title' => 'Gajian',
                'amount' => 5000000,
                'account_bank' => 'BCA',
                'date' => '2025-06-01',
                'description' => 'gaji bulanan',
            ],
            (object) [
                'id' => 4,
                'title' => 'Gajian',
                'amount' => 5000000,
                'account_bank' => 'BCA',
                'date' => '2025-06-01',
                'description' => 'gaji bulanan',
            ],
            (object) [
                'id' => 5,
                'title' => 'Gajian',
                'amount' => 5000000,
                'account_bank' => 'BCA',
                'date' => '2025-06-01',
                'description' => 'gaji bulanan',
            ],
            (object) [
                'id' => 6,
                'title' => 'Gajian',
                'amount' => 5000000,
                'account_bank' => 'BCA',
                'date' => '2025-06-01',
                'description' => 'gaji bulanan',
            ],
        ];
    }
}
