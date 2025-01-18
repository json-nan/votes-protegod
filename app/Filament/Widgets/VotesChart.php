<?php

namespace App\Filament\Widgets;

use App\Models\Vote;
use Filament\Widgets\ChartWidget;

class VotesChart extends ChartWidget
{
    protected static ?string $heading = 'Votos confirmados y pendientes';

    protected function getData(): array
    {
        $votes = Vote::selectRaw("
    SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed_count,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count
")->first();

        return [
            'labels' => ['Confirmados', 'Pendientes'],
            'datasets' => [
                [
                    'label' => 'Votes',
                    'data' => [$votes->confirmed_count, $votes->pending_count],
                    'backgroundColor' => [
                        '#4B0082',
                        '#8A2BE2',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    public function getColumnSpan(): int
    {
        return 3;
    }

    protected function getMaxHeight(): ?string
    {
        return '300px';
    }
}
