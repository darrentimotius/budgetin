<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index() {
        $categories = Category::all();
        confirmDelete('Are you sure you want to delete this category?');
        return view('pages.transaction.category', ['title' => 'Category'], compact('categories'));
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name'=> ['required', 'string', 'max:255'],
            'monthly_budget'=> ['required'],
            'icon' => ['required']
        ]);

        Category::create([
            'name' => $validated['name'],
            'icon' => $validated['icon'],
            'monthly_budget' => $validated['monthly_budget'],
            'user_id' => Auth::id(),
            'slug' => Category::generateSlug($validated['name'])
        ]);

        toast()->success('Category created!');
        return redirect()->back()->with('success', 'Category created!');
    }

    public function update(Request $request, $slug){
        $validated = $request->validate([
            'name'=> ['required', 'string', 'max:255'],
            'monthly_budget'=> ['required'],
            'icon'=> ['required']
        ]);

        $category = Category::where('slug', $slug)->firstOrFail();

        $category->update([
            'name' => $validated['name'],
            'icon' => $validated['icon'],
            'monthly_budget' => $validated['monthly_budget'],
            'user_id' => Auth::id(),
            'slug' => Category::generateSlug($validated['name'])
        ]);

        toast()->success('Category updated!');
        return redirect()->back()->with('success', 'Category updated!');;
    }

    public function destroy($slug){
        Category::where('slug', $slug)->delete();

        toast()->success('Category deleted!');
        return redirect()->route('category.index');
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
