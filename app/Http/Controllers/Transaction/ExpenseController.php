<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index() {
        $expenses = Transaction::with(['fromAccount', 'category'])
            ->where('user_id', Auth::id())
            ->where('type', 'expense')
            ->get();
        $categories = Category::where('user_id', Auth::id())->get();
        $accounts = Account::where('user_id', Auth::id())->get();

        confirmDelete('Are you sure you want to delete this expense?');
        return view('pages.transaction.expense', ['title' => 'Expense'], compact('expenses', 'categories', 'accounts'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title'=> ['required'],
            'from_account_id' => ['required', 'exists:accounts,id'],
            'category_id'     => ['required'],
            'amount'          => ['required'],
            'date'            => ['required'],
            'description' => ['nullable', 'string', 'max:200']
        ]);
        

        try {
            DB::beginTransaction();

            $amount = (int) preg_replace('/[^0-9]/', '', $validated['amount']);

            $from = Account::where('id', $validated['from_account_id'])
                ->where('user_id', Auth::id())->firstOrFail();

            $from->decrement('balance', $amount);

            Transaction::create([
                'user_id'         => Auth::id(),
                'type'            => 'expense',
                'title'           => $validated['title'],
                'amount'          => $amount,
                'from_account_id' => $from->id,
                'category_id'     => $validated['category_id'],
                'date'            => Carbon::createFromFormat('d-m-Y', $validated['date'])->format('Y-m-d'),
                'description'     => $validated['description'],
            ]);

            DB::commit();

            toast()->success('Expense created!');
            return redirect()->back();

        } catch (\Throwable $th) {
            DB::rollBack();

            toast()->error('Failed to create expense');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id){
        $expense = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('type', 'expense')
            ->firstOrFail();

        $validated = $request->validate([
            'title'=> ['required'],
            'from_account_id' => ['required', 'exists:accounts,id'],
            'category_id'     => ['required'],
            'amount'          => ['required'],
            'date'            => ['required'],
            'description' => ['nullable', 'string', 'max:200']
        ]);

        try {
            DB::beginTransaction();

            $oldAmount = $expense->amount;
            $oldFrom = Account::where('id', $expense->from_account_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            $oldFrom->increment('balance', $oldAmount);

            $newAmount = (int) preg_replace('/[^0-9]/', '', $validated['amount']);

            $newFrom = Account::where('id', $validated['from_account_id'])
                ->where('user_id', Auth::id())->firstOrFail();

            $newFrom->decrement('balance', $newAmount);

            $expense->update([
                'user_id'         => Auth::id(),
                'type'            => 'expense',
                'title'           => $validated['title'],
                'amount'          => $newAmount,
                'from_account_id' => $newFrom->id,
                'category_id'     => $validated['category_id'],
                'date'            => Carbon::createFromFormat('d-m-Y', $validated['date'])->format('Y-m-d'),
                'description'     => $validated['description'],
            ]);

            DB::commit();

            toast()->success('Expense updated!');
            return redirect()->back();

        } catch (\Throwable $th) {
            DB::rollBack();

            toast()->error('Failed to update expense');
            return redirect()->back();
        }
    }

    public function destroy($id){
        $expense = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('type', 'expense')
            ->firstOrFail();

        try {
            DB::beginTransaction();

            Account::where('id', $expense->from_account_id)
                ->increment('balance', $expense->amount);

            $expense->delete();

            DB::commit();

            toast()->success('Expense deleted!');
            return redirect()->back();

        } catch(\Throwable $e){
            DB::rollBack();

            toast()->error('Delete failed!');
            return redirect()->back();
        }
    }
}
