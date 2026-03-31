<x-mail::message>
# Inscription de Commande

Hello {{ $order->user->name }},

Thank you for choosing **Larins**. Your selection has been received and is currently being prepared with care for our collection.

<x-mail::panel>
**ARCHIVE REFERENCE** <span style="font-size: 20px; font-weight: 900; letter-spacing: 4px; color: #b45309; font-style: italic;">
    #{{ $order->order_number ?? $order->id }}
</span>
</x-mail::panel>

Your acquisition is officially confirmed. You may monitor the progress of your items by visiting your personal dashboard below.

<x-mail::button :url="$url" color="primary">
Explore Your Collection
</x-mail::button>

If you have any questions regarding your selection, please do not hesitate to contact our concierge.

Au plaisir,<br>
**The {{ config('app.name') }} Maison**
</x-mail::message>