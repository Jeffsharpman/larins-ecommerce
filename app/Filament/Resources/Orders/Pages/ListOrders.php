<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Filament\Resources\Orders\Widgets\OrderStats; // Import your widget
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Add this to show widgets at the TOP of the table
    protected function getHeaderWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    public function getTabs(): Array {
        return [
            null => Tab::make('ALL'),
            'New' => Tab::make()->query(fn ($query) => $query->where('status', 'new')),
            'Processing' => Tab::make()->query(fn ($query) => $query->where('status', 'processing')),
            'Shipped' => Tab::make()->query(fn ($query) => $query->where('status', 'shipped')),
            'Delivered' => Tab::make()->query(fn ($query) => $query->where('status', 'delivered')),
            'Cancelled' => Tab::make()->query(fn ($query) => $query->where('status', 'cancelled')),
        ];
    }
}