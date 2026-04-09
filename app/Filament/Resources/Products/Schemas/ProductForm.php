<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()->schema([
                    Section::make('Product Information')->schema([
                        TextInput::make('name')
                            ->label('Product Name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            // ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                            ->afterStateUpdated(function (string $operation, $state, Set $set) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->label('URL Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Product::class, 'slug', ignoreRecord: true)
                            ->alphaDash(),

                        MarkdownEditor::make('description')
                            ->columnSpanfull()
                            ->fileAttachmentsDirectory('products'),
                    ])->columns(2),

                    Section::make('images')->schema([
                        SpatieMediaLibraryFileUpload::make('images')
                            ->image()
                            ->multiple()
                            ->collection('images')
                            ->directory('products')
                            ->reorderable()
                            ->imageEditor()
                            ->panelLayout('grid')
                            ->maxFiles(5)
                            ->downloadable()
                            ->disk('public')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->maxSize(5120),
                    ]),

                ])->columnSpan(2),

                Group::make()->schema([
                    Section::make('Price')->schema([
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('NGN'),

                        TextInput::make('old_price')
                            ->label('Old Price (Original)')
                            ->numeric()
                            ->prefix('NGN')
                            ->helperText('Show this when product is on sale'),

                        TextInput::make('sale_price')
                            ->label('Sale Price')
                            ->numeric()
                            ->prefix('NGN')
                            ->helperText('Leave empty or set lower than price'),

                        TextInput::make('stock')
                            ->label('Stock (for products without variants)')
                            ->numeric()
                            ->default(0)
                            ->helperText('Leave at 0 if product has variants. Stock will be calculated from variants.')
                            ->hidden(fn (string $operation): bool => $operation === 'view'),
                    ]),

                    Section::make('Associations')->schema([
                        Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Category Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Category::class, 'slug', ignoreRecord: true)
                                    ->alphaDash(),

                                SpatieMediaLibraryFileUpload::make('image')
                                    ->image()
                                    ->collection('image')
                                    ->directory('categories'),

                                Toggle::make('is_active')
                                    ->label('Is Active')
                                    ->default(true),
                            ]),

                        Select::make('brand_id')
                            ->label('Brand')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Brand Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Brand::class, 'slug', ignoreRecord: true)
                                    ->alphaDash(),

                                SpatieMediaLibraryFileUpload::make('image')
                                    ->image()
                                    ->collection('image')
                                    ->directory('brands'),

                                Toggle::make('is_active')
                                    ->label('Is Active')
                                    ->default(true),
                            ]),
                    ]),

                    Section::make('Status')->schema([
                        Toggle::make('is_active')
                            ->required(),
                        Toggle::make('is_featured')
                            ->required(),
                        Toggle::make('in_stock')
                            ->required(),
                        Toggle::make('on_sale')
                            ->required(),
                    ]),
                ])
                    ->columnSpan(1),
                Group::make()->schema([
                    Section::make('Product Variants')
                        ->description('Manage different sizes, colors, or versions of this product.')
                        ->schema([
                            Repeater::make('variants')
                                ->relationship() // This automatically links to the variants() method in the Model
                                ->schema([
                                    TextInput::make('name')
                                        ->label('Variant Name')
                                        ->placeholder('e.g. Blue / Large')
                                        ->required()
                                        ->columnSpan(2),

                                    TextInput::make('sku')
                                        ->label('SKU')
                                        ->required()
                                        ->unique(ignoreRecord: true),

                                    TextInput::make('price')
                                        ->numeric()
                                        ->prefix(fn () => config('app.currency_symbol', '₦')) // Dynamic from your settings!
                                        ->placeholder('Leave empty to use base price'),

                                    TextInput::make('stock')
                                        ->numeric()
                                        ->default(0)
                                        ->required(),
                                ])
                                ->columns(4)
                                ->grid(1) // Stack them nicely
                                ->collapsible() // Keeps the UI clean when you have 10+ variants
                                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null),
                        ]),
                ])->columnSpanFull(),
            ])->columns(3);
    }
}
