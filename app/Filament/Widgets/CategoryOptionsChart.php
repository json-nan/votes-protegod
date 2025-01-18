<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class CategoryOptionsChart extends ChartWidget
{
    public Category $category;

    public function getHeading(): string
    {
        return $this->category->name;
    }

    protected function getData(): array
    {
        return [
            'labels' => $this->category->options->pluck('title')->toArray(),
            'datasets' => [
                [
                    'label' => 'Votes',
                    'data' => $this->category->options->pluck('votes')->map(fn ($votes) => $votes->count())->toArray(),
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
