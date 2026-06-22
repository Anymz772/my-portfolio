<?php

namespace App\Filament\Widgets;

use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Skill;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Projects', Project::count())
                ->description('Published projects')
                ->icon('heroicon-o-folder'),
            Stat::make('Skills', Skill::count())
                ->description('Active skills')
                ->icon('heroicon-o-academic-cap'),
            Stat::make('Unread Messages', ContactMessage::where('is_read', false)->count())
                ->description('New inquiries')
                ->icon('heroicon-o-envelope'),
        ];
    }
}
