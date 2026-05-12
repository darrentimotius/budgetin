<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;

class InvestmentController extends Controller
{
    public function index()
    {
        $targets = collect($this->getTargets())->map(function ($target) {

            $items = collect($target->items);

            $target->total_current = $items->sum('current_amount');

            $target->percentage = $target->target_amount > 0
                ? round(($target->total_current / $target->target_amount) * 100, 0)
                : 0;

            $target->items = $items->map(function ($item) use ($target) {

                $item->target_amount = round(
                    $target->target_amount * $item->allocation
                );

                $item->percentage = $item->target_amount > 0
                    ? round(($item->current_amount / $item->target_amount) * 100, 0)
                    : 0;

                $item->allocation_percentage = round($item->allocation * 100);

                return $item;
            });

            return $target;
        });

        $total_target = $targets->sum('target_amount');
        $total_investment = $targets->sum('total_current');
        $allocation_chart = $targets->map(function ($target) {
            return [
                'label' => $target->title,
                'value' => $target->target_amount,
            ];
        })->values();

        $percentage = $total_target > 0
            ? round(($total_investment / $total_target) * 100, 0)
            : 0;

        $remaining_target = $total_target - $total_investment;

        $datas = [
            'summary' => [
                'total_target' => $total_target,
                'total_investment' => $total_investment,
                'remaining_target' => $remaining_target,
                'percentage' => $percentage,
            ],
            'targets' => $targets,
            'allocation_chart' => $allocation_chart,
        ];

        return view('pages.investment.investment', ['title' => 'Investment'], compact('datas'));
    }

    public function getTargets()
    {
        return [
            (object) [
                'title' => 'Emergency Fund',
                'icon' => 'home',
                'target_amount' => 25000000,
                'items' => [
                    (object) [
                        'title' => 'Cash',
                        'allocation' => 0.5,
                        'current_amount' => 6000000,
                        ],
                        (object) [
                        'title' => 'Money Market',
                        'allocation' => 0.5,
                        'current_amount' => 5000000,
                    ],
                ],
            ],
            (object) [
                'title' => 'Monthly Savings',
                'icon' => 'credit-card',
                'target_amount' => 15000000,
                'items' => [
                    (object) [
                        'title' => 'blu',
                        'allocation' => 1,
                        'current_amount' => 5000000,
                    ],
                ],
            ],
        ];
    }
}
