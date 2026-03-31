<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Reviewer Information')->schema([
                        Select::make('user_id')
                            ->label('Customer')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('product_id')
                            ->label('Product')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])->columns(2),

                    Section::make('Rating & Content')->schema([
                        Radio::make('rating')
                            ->label('Rating')
                            ->options([
                                1 => '1 Star - Poor',
                                2 => '2 Stars - Fair',
                                3 => '3 Stars - Good',
                                4 => '4 Stars - Very Good',
                                5 => '5 Stars - Excellent',
                            ])
                            ->required(),

                        TextInput::make('title')
                            ->label('Review Title')
                            ->maxLength(255),

                        Textarea::make('comment')
                            ->label('Review Comment')
                            ->rows(5),
                    ])->columns(2),

                    Section::make('Moderation')->schema([
                        Toggle::make('is_approved')
                            ->label('Approved for publication')
                            ->default(false),
                    ]),
                ])->columnSpanFull(),
            ]);
    }
}
