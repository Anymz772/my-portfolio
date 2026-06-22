<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExperienceResource\Pages;
use App\Models\Experience;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class ExperienceResource extends Resource
{
    protected static ?string $model = Experience::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationLabel = 'Experience';

    protected static ?string $pluralLabel = 'Experiences';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Company Details')
                    ->schema([
                        Forms\Components\TextInput::make('company')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Google, Microsoft, etc.'),
                        Forms\Components\TextInput::make('role')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Senior Developer'),
                        Forms\Components\TextInput::make('location')
                            ->maxLength(255)
                            ->placeholder('San Francisco, CA (or Remote)'),
                    ])->columns(2),

                Forms\Components\Section::make('Dates')
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->required()
                            ->native(false)
                            ->displayFormat('M d, Y')
                            ->label('Start Date'),
                        Forms\Components\DatePicker::make('end_date')
                            ->native(false)
                            ->displayFormat('M d, Y')
                            ->label('End Date')
                            ->helperText('Leave empty if this is your current position'),
                    ])->columns(2),

                Forms\Components\Section::make('Description & Status')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->rows(4)
                            ->maxLength(65535)
                            ->placeholder('Describe your responsibilities and achievements...'),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true)
                            ->label('Active Experience'),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Sort Order')
                            ->helperText('Lower numbers appear first'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->icon('heroicon-o-building-office'),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->sortable()
                    ->color('primary'),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date('M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date('M Y')
                    ->placeholder('Present')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration')
                    ->getStateUsing(function ($record) {
                        $start = Carbon::parse($record->start_date);
                        $end = $record->end_date ? Carbon::parse($record->end_date) : Carbon::now();
                        $diff = $start->diff($end);

                        $years = $diff->y;
                        $months = $diff->m;

                        if ($years > 0 && $months > 0) {
                            return "{$years}y {$months}m";
                        } elseif ($years > 0) {
                            return "{$years}y";
                        } elseif ($months > 0) {
                            return "{$months}m";
                        }

                        return '< 1m';
                    })
                    ->badge()
                    ->color('success'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueLabel('Only Active')
                    ->falseLabel('Only Inactive')
                    ->native(false),
                Tables\Filters\Filter::make('current_position')
                    ->label('Current Position')
                    ->query(fn ($query) => $query->whereNull('end_date')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExperiences::route('/'),
            'create' => Pages\CreateExperience::route('/create'),
            'edit' => Pages\EditExperience::route('/{record}/edit'),
        ];
    }
}
