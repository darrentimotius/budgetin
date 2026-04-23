<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index() {
        $categories = $this->getCategories();
        confirmDelete('Are you sure you want to delete this category?');
        return view('pages.transaction.category', ['title' => 'Category'], compact('categories'));
    }

    public function getCategories() {
        return [
            (object) [
                'id' => 1,
                'icon' => 'home',
                'name' => 'Shopping',
                'monthly_budget' => 500000,
                'expense_this_month' => 0,
                'usage' => '0%',
            ],
            (object) [
                'id' => 2,
                'icon' => 'home',
                'name' => 'Transportation',
                'monthly_budget' => 500000,
                'expense_this_month' => 0,
                'usage' => '0%',
            ],
            (object) [
                'id' => 3,
                'icon' => 'home',
                'name' => 'Daily Food',
                'monthly_budget' => 500000,
                'expense_this_month' => 0,
                'usage' => '0%',
            ],
            (object) [
                'id' => 4,
                'icon' => 'home',
                'name' => 'Dining Out',
                'monthly_budget' => 500000,
                'expense_this_month' => 0,
                'usage' => '0%',
            ],
            (object) [
                'id' => 5,
                'icon' => 'home',
                'name' => 'Subscription',
                'monthly_budget' => 500000,
                'expense_this_month' => 0,
                'usage' => '0%',
            ],
            (object) [
                'id' => 6,
                'icon' => 'home',
                'name' => 'Holiday',
                'monthly_budget' => 500000,
                'expense_this_month' => 0,
                'usage' => '0%',
            ],
        ];
    }
}
