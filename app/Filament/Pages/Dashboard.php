<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CategoryOptionsChart;
use App\Filament\Widgets\VotesChart;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getColumns(): int|string|array
    {
        return 3;
    }

    public function getWidgets(): array
    {
        $categories = \App\Models\Category::active()->with('options.votes')->get();
        $categoryCharts = $categories->map(function ($category) {
            return CategoryOptionsChart::make([
                'category' => $category,
            ]);
        })->toArray();

        return [
            //            VotesChart::class,
            ...$categoryCharts,
        ];
    }
}
