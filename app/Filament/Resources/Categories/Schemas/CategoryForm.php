<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Information')->schema([
                    TextInput::make('name')
                        ->label('Category Name')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                            $set('slug', Str::slug($state));
                        }),

                    TextInput::make('slug')
                        ->label('URL Slug')
                        ->required()
                        ->maxLength(255)
                        // Ensure uniqueness except for the current record during an update
                        ->unique(Category::class, 'slug', ignoreRecord: true)
                        ->helperText('Auto-generated from name on blur. You can edit it manually.')
                        ->placeholder('example-product-name')
                        // alphaDash ensures the slug only contains a-z, 0-9, -, and _
                        ->alphaDash()
                        ->dehydrated(),
                ])->columnSpan(1)->columns(2),

                Section::make('status')->schema([
                    Toggle::make('is_active')
                        ->required(),
                ])->columns(1),

                Section::make('Image')->schema([
                    TextInput::make('image')
                        ->label('Image URL')
                        ->url()
                        ->placeholder('https://example.com/images/category.jpg'),
                ])->columnSpanFull(),

                MarkdownEditor::make('description')
                    ->columnSpanfull()
                    ->fileAttachmentsDirectory('categories'),

            ])->columns(2);
    }
}
