<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index() {
        $expenses = $this->getExpense();
        confirmDelete('Are you sure you want to delete this expense?');
        return view('pages.transaction.expense', ['title' => 'Expense'], compact('expenses'));
    }

    public function getExpense() {
        return [
            (object) [
                'id' => 1,
                'title' => 'Beli Marugame',
                'amount' => 50000,
                'account_bank' => 'BCA',
                'category' => 'Food',
                'date' => '2025-06-01',
                'description' => 'Makan di Aeon',
            ],
            (object) [
                'id' => 2,
                'title' => 'Beli Marugame',
                'amount' => 50000,
                'account_bank' => 'BCA',
                'category' => 'Food',
                'date' => '2025-06-01',
                'description' => 'Makan di Aeon',
            ],
            (object) [
                'id' => 3,
                'title' => 'Beli Marugame',
                'amount' => 50000,
                'account_bank' => 'BCA',
                'category' => 'Food',
                'date' => '2025-06-01',
                'description' => 'Makan di Aeon',
            ],
            (object) [
                'id' => 4,
                'title' => 'Beli Marugame',
                'amount' => 50000,
                'account_bank' => 'BCA',
                'category' => 'Food',
                'date' => '2025-06-01',
                'description' => 'Makan di Aeon',
            ],
            (object) [
                'id' => 5,
                'title' => 'Beli Marugame',
                'amount' => 50000,
                'account_bank' => 'BCA',
                'category' => 'Food',
                'date' => '2025-06-01',
                'description' => 'Makan di Aeon',
            ],
            (object) [
                'id' => 6,
                'title' => 'Beli Marugame',
                'amount' => 50000,
                'account_bank' => 'BCA',
                'category' => 'Food',
                'date' => '2025-06-01',
                'description' => 'Makan di Aeon',
            ],
        ];
    }
}
