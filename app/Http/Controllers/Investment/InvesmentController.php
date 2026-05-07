<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;

class InvesmentController extends Controller
{
    public function index()
    {
        $targets = $this->getTargets();

        $collection = collect($targets);

        $total_target = $collection->sum('target_amount');
        $total_investment = $collection->sum('current_amount');

        $targets = $collection->map(function ($item) {
            $item->percentage = $item->target_amount > 0
                ? round(($item->current_amount / $item->target_amount) * 100, 2)
                : 0;

            return $item;
        });

        $percentage = $total_target > 0
            ? round(($total_investment / $total_target) * 100, 0)
            : 0;

        $remaining_target = $total_target - $total_investment;

        $datas = [
            'total_target' => $total_target,
            'total_investment' => $total_investment,
            'remaining_target' => $remaining_target,
            'percentage' => $percentage,
            'targets' => $targets,
        ];

        return view('pages.investment.investment', ['title' => 'Investment'], compact('datas'));
    }

    public function getTargets()
    {
        return [
            (object) [
                'title' => 'Emergency Fund',
                'icon' => 'home',
                'current_amount' => 10000000,
                'target_amount' => 20000000,
            ],
            (object) [
                'title' => 'Emergency Fund',
                'icon' => 'credit-card',
                'current_amount' => 10000000,
                'target_amount' => 20000000,
            ],
            (object) [
                'title' => 'Emergency Fund',
                'icon' => 'home',
                'current_amount' => 10000000,
                'target_amount' => 20000000,
            ],
            (object) [
                'title' => 'Emergency Fund',
                'icon' => 'credit-card',
                'current_amount' => 15000000,
                'target_amount' => 20000000,
            ],
            (object) [
                'title' => 'Emergency Fund',
                'icon' => 'home',
                'current_amount' => 3700000,
                'target_amount' => 20000000,
            ],
        ];
    }
}
