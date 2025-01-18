<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\CategoryOptionsChart;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getColumns(): int|string|array
    {
        return 3;
    }

    public function getWidgets(): array
    {
        $categories = \App\Models\Category::active()->with('options.votes')->get();

        return $categories->map(function ($category) {
            return CategoryOptionsChart::make([
                'category' => $category,
            ]);
        })->toArray();
    }
}
