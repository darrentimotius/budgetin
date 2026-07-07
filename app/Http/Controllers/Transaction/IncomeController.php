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

class IncomeController extends Controller
{
    public function index() {
        $incomes = Transaction::with(['toAccount'])
            ->where('user_id', Auth::id())
            ->where('type', 'income')
            ->get();
        $accounts = Account::where('user_id', Auth::id())->get();

        confirmDelete('Are you sure you want to delete this income?');
        return view('pages.transaction.income', ['title' => 'Income'], compact('incomes', 'accounts'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title'=> ['required'],
            'to_account_id' => ['required', 'exists:accounts,id'],
            'amount'          => ['required'],
            'date'            => ['required'],
            'description' => ['nullable', 'string', 'max:200']
        ]);

        try {
            DB::beginTransaction();

            $amount = (int) preg_replace('/[^0-9]/', '', $validated['amount']);

            $to = Account::where('id', $validated['to_account_id'])
                ->where('user_id', Auth::id())->firstOrFail();

            $to->increment('balance', $amount);

            Transaction::create([
                'user_id'         => Auth::id(),
                'type'            => 'income',
                'title'           => $validated['title'],
                'amount'          => $amount,
                'to_account_id' => $to->id,
                'date'            => Carbon::createFromFormat('d-m-Y', $validated['date'])->format('Y-m-d'),
                'description'     => $validated['description'],
            ]);

            DB::commit();

            toast()->success('Income created!');
            return redirect()->back();

        } catch (\Throwable $th) {
            DB::rollBack();

            toast()->error('Failed to create income');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id){
        $incomes = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('type', 'income')
            ->firstOrFail();

        $validated = $request->validate([
            'title'=> ['required'],
            'to_account_id' => ['required', 'exists:accounts,id'],
            'amount'          => ['required'],
            'date'            => ['required'],
            'description' => ['nullable', 'string', 'max:200']
        ]);

        try {
            DB::beginTransaction();

            $oldAmount = $incomes->amount;
            $oldTo = Account::where('id', $incomes->to_account_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            $oldTo->increment('balance', $oldAmount);

            $newAmount = (int) preg_replace('/[^0-9]/', '', $validated['amount']);

            $newTo = Account::where('id', $validated['to_account_id'])
                ->where('user_id', Auth::id())->firstOrFail();

            $newTo->decrement('balance', $newAmount);

            $incomes->update([
                'user_id'         => Auth::id(),
                'type'            => 'income',
                'title'           => $validated['title'],
                'amount'          => $newAmount,
                'to_account_id' => $newTo->id,
                'date'            => Carbon::createFromFormat('d-m-Y', $validated['date'])->format('Y-m-d'),
                'description'     => $validated['description'],
            ]);

            DB::commit();

            toast()->success('Income updated!');
            return redirect()->back();

        } catch (\Throwable $th) {
            DB::rollBack();

            toast()->error('Failed to update income');
            return redirect()->back();
        }
    }

    public function destroy($id){
        $incomes = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('type', 'income')
            ->firstOrFail();

        try {
            DB::beginTransaction();

            Account::where('id', $incomes->to_account_id)
                ->increment('balance', $incomes->amount);

            $incomes->delete();

            DB::commit();

            toast()->success('Income deleted!');
            return redirect()->back();

        } catch(\Throwable $e){
            DB::rollBack();

            toast()->error('Delete failed!');
            return redirect()->back();
        }
    }

}
