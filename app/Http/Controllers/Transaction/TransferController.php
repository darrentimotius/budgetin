<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Transaction;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransferController extends Controller
{
    public function index() {
        $transfers = Transaction::with(['fromAccount', 'toAccount'])
            ->where('user_id', Auth::id())
            ->where('type', 'transfer')
            ->get();

        $accounts = Account::where('user_id', Auth::id())->get();

        confirmDelete('Are you sure you want to delete this transfer?');
        return(view('pages.transaction.transfer', ['title' => 'Transfer'], compact('transfers', 'accounts')));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_account_id' => ['required', 'exists:accounts,id'],
            'to_account_id'   => ['required', 'different:from_account_id', 'exists:accounts,id'],
            'amount'          => ['required'],
            'date'            => ['required'],
            'description'     => ['nullable', 'string', 'max:200'],
        ]);

        try {
            DB::beginTransaction();

            $amount = (int) preg_replace('/[^0-9]/', '', $validated['amount']);
            // $amount = $validated['amount'];

            $from = Account::where('id', $validated['from_account_id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $to = Account::where('id', $validated['to_account_id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $from->decrement('balance', $amount);
            $to->increment('balance', $amount);

            Transaction::create([
                'user_id'         => Auth::id(),
                'type'            => 'transfer',
                'title'           => 'Transfer',
                'amount'          => $amount,
                'from_account_id' => $from->id,
                'to_account_id'   => $to->id,
                'date'            => Carbon::createFromFormat('d-m-Y', $validated['date'])->format('Y-m-d'),
                'description'     => $validated['description'],
            ]);

            DB::commit();

            toast()->success('Transfer successful!');
            return back();

        } catch (\Throwable $e) {
            DB::rollBack();
            toast()->error('Transfer failed!');
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        $transfer = Transaction::where('type', 'transfer')
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $validated = $request->validate([
            'from_account_id' => ['required', 'exists:accounts,id'],
            'to_account_id'   => ['required', 'different:from_account_id', 'exists:accounts,id'],
            'amount'          => ['required'],
            'date'            => ['required'],
            'description'     => ['nullable', 'string', 'max:200'],
        ]);

        try {
            DB::beginTransaction();

            // $amount = (int) preg_replace('/[^0-9]/', '', $validated['amount']);
            $oldAmount = $transfer->amount;

            $oldFrom = Account::where('id', $transfer->from_account_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();
            $oldTo = Account::where('id', $transfer->to_account_id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $oldFrom->increment('balance', $transfer->amount);
            $oldTo->decrement('balance', $transfer->amount);

            $newAmount = (int) preg_replace('/[^0-9]/', '', $validated['amount']);

            $newFrom = Account::where('id', $validated['from_account_id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $newTo = Account::where('id', $validated['to_account_id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $newFrom->decrement('balance', $newAmount);
            $newTo->increment('balance', $newAmount);

            $transfer->update([
                'user_id'         => Auth::id(),
                'type'            => 'transfer',
                'title'           => 'Transfer',
                'amount'          => $newAmount,
                'from_account_id' => $newFrom->id,
                'to_account_id'   => $newTo->id,
                'date'            => Carbon::createFromFormat('d-m-Y', $validated['date'])->format('Y-m-d'),
                'description'     => $validated['description'],
            ]);

            DB::commit();

            toast()->success('Transfer updated!');
            return back();

        } catch (\Throwable $e) {
            DB::rollBack();

            toast()->error('Transfer failed to update!');
            return back();
        }
    }

    public function destroy($id){
        $transfer = Transaction::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('type', 'transfer')
            ->firstOrFail();
        
        try {
            DB::beginTransaction();

            Account::where('id', $transfer->from_account_id)
                ->increment('balance', $transfer->amount);
            Account::where('id', $transfer->to_account_id)
                ->decrement('balance', $transfer->amount);
            $transfer->delete();

            DB::commit();

            toast()->success('Transfer deleted!');
            return redirect()->back();

        } catch(\Exception $e){
            DB::rollBack();

            toast()->error('Delete failed!');
            return redirect()->back();
        }
    }
}
