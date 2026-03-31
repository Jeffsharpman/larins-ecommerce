{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}



@component('mail::message')
# Low Stock Alert

The following items are running low on inventory. Please restock soon!

@component('mail::table')
| Product | Variant | Current Stock |
| :--- | :--- | :--- |
@foreach ($items as $item)
| {{ $item->product->name }} | {{ $item->name }} | **{{ $item->stock }}** |
@endforeach
@endcomponent

@component('mail::button', ['url' => config('app.url') . '/admin/products'])
View Catalog
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent