<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;

class InvestmentController extends Controller
{
    public function index()
    {
        $targets = collect($this->getTargets())->map(function ($target) {

            $items = collect($target->items);

            $target->total_target = $items->sum('target_amount');
            $target->total_current = $items->sum('current_amount');

            $target->percentage = $target->total_target > 0
                ? round(($target->total_current / $target->total_target) * 100, 0)
                : 0;

            $target->items = $items->map(function ($item) use ($target) {

                $item->percentage = $item->target_amount > 0
                    ? round(($item->current_amount / $item->target_amount) * 100, 0)
                    : 0;

                $item->allocation = $target->total_target > 0
                    ? round(($item->target_amount / $target->total_target) * 100, 0)
                    : 0;

                return $item;
            });

            return $target;
        });

        $total_target = $targets->sum('total_target');
        $total_investment = $targets->sum('total_current');
        $allocation_chart = $targets->map(function ($target) {
            return [
                'label' => $target->title,
                'value' => $target->total_target,
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
                'items' => [
                    (object) [
                        'title' => 'Cash',
                        'icon' => 'home',
                        'current_amount' => 10000000,
                        'target_amount' => 20000000,
                    ],
                    (object) [
                        'title' => 'Money Market',
                        'icon' => 'credit-card',
                        'current_amount' => 15000000,
                        'target_amount' => 20000000,
                    ],
                ],
            ],
            (object) [
                'title' => 'Monthly Savings',
                'icon' => 'credit-card',
                'items' => [
                    (object) [
                        'title' => 'blu',
                        'icon' => 'home',
                        'current_amount' => 5000000,
                        'target_amount' => 15000000,
                    ],
                    (object) [
                        'title' => 'blu',
                        'icon' => 'home',
                        'current_amount' => 5000000,
                        'target_amount' => 15000000,
                    ],
                    (object) [
                        'title' => 'blu',
                        'icon' => 'home',
                        'current_amount' => 5000000,
                        'target_amount' => 15000000,
                    ],
                ],
            ],
        ];
    }
}
