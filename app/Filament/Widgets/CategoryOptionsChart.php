<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

class CategoryOptionsChart extends ChartWidget
{
    public Category $category;

    protected int|string|array $columnSpan = 1;

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
                    'backgroundColor' => [
                        //                        up to 10 different colors
                        '#4B0082',
                        '#8A2BE2',
                        '#C71585',
                        '#9400D3',
                        '#FF00FF',
                        '#00FFFF',
                        '#39FF14',
                        '#FFC107',
                        '#FF4500',
                        '#2F4F4F',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }

    protected function getMaxHeight(): ?string
    {
        return '450px';
    }
}
