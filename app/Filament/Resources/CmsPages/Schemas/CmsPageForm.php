<?php

namespace App\Filament\Resources\CmsPages\Schemas;

use App\Models\Page;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;

class CmsPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Page Content')->schema([
                        TextInput::make('title')
                            ->label('Page Title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true),

                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Page::class, 'slug', ignoreRecord: true)
                            ->helperText('Auto-generated from title. You can edit manually.'),

                        MarkdownEditor::make('content')
                            ->label('Page Content')
                            ->fileAttachmentsDirectory('pages')
                            ->columnSpanFull(),
                    ])->columns(2),
                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('SEO')->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(70)
                            ->helperText('Recommended: 50-60 characters'),

                        TextInput::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->helperText('Recommended: 150-160 characters'),
                    ])->columns(1),

                    Section::make('Status')->schema([
                        Toggle::make('is_active')
                            ->label('Published')
                            ->default(true),
                    ]),
                ])->columnSpan(1),
            ])->columns(3);
    }
}
