@props(['order', 'statusSteps'])

@php
  $statusClasses = match ($order->status) {
      'delivered' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-600', 'icon' => 'check-circle'],
      'cancelled' => ['bg' => 'bg-destructive/10', 'text' => 'text-destructive', 'icon' => 'x-circle'],
      'shipped' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-600', 'icon' => 'truck'],
      default => ['bg' => 'bg-gold/10', 'text' => 'text-gold', 'icon' => 'package'],
  };

  $currentIndex = array_search($order->status, $statusSteps);
@endphp

<div class="space-y-8 animate-in fade-in duration-700">
  <nav>
    <a href="{{ route('my-orders') }}" wire:navigate
      class="inline-flex items-center gap-2 text-muted-foreground hover:text-gold transition-colors px-4 py-2 rounded-larins hover:bg-gold/5 group">
      <x-lucide-arrow-left class="w-4 h-4 group-hover:-translate-x-1 transition-transform" />
      <span class="font-bold uppercase text-xs tracking-widest">Back to history</span>
    </a>
  </nav>

  <div class="bg-card p-8 rounded-larins shadow-card border border-border relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-gold/5 rounded-full -mr-16 -mt-16 blur-3xl"></div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
      <div class="flex items-center gap-5">
        <div class="w-16 h-16 {{ $statusClasses['bg'] }} rounded-2xl flex items-center justify-center shadow-soft">
          <x-dynamic-component :component="'lucide-' . $statusClasses['icon']" class="w-8 h-8 {{ $statusClasses['text'] }}" />
        </div>
        <div>
          <h1 class="text-3xl font-bold font-heading tracking-tighter">Order <span
              class="text-gold">#{{ $order->order_number ?? $order->id }}</span></h1>
          <div class="flex flex-wrap gap-4 text-xs font-bold uppercase tracking-widest text-muted-foreground mt-2">
            <span class="flex items-center gap-1.5">
              <x-lucide-calendar class="w-3.5 h-3.5 text-gold" />
              {{ $order->created_at->format('d M, Y • H:i') }}
            </span>
            <span class="flex items-center gap-1.5">
              <x-lucide-shield-check class="w-3.5 h-3.5 text-gold" />
              <span class="{{ $statusClasses['text'] }}">{{ $order->status }}</span>
            </span>
          </div>
        </div>
      </div>
      <div class="bg-muted/30 p-4 rounded-xl border border-border/50 text-right">
        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground block mb-1">Total
          Paid</span>
        <span
          class="text-3xl font-bold text-foreground font-heading">{{ Number::currency($order->total, 'NGN') }}</span>
      </div>
    </div>

    <div class="mb-16 px-4">
      <h2 class="text-xs font-black uppercase tracking-[0.3em] text-muted-foreground mb-10 flex items-center gap-2">
        <x-lucide-route class="w-4 h-4 text-gold" />
        Live Status Tracker
      </h2>
      <div class="flex justify-between items-start relative">
        @foreach ($statusSteps as $index => $step)
          @php
            $isCompleted = array_search($step, $statusSteps) <= $currentIndex;
            $isCurrent = $step === $order->status;
          @endphp

          <div class="flex-1 flex flex-col items-center group relative">
            @if (!$loop->last)
              <div class="absolute top-6 left-1/2 w-full h-[2px] bg-muted -z-10">
                <div class="h-full bg-gold transition-all duration-1000"
                  style="width: {{ $isCompleted ? '100%' : '0%' }}"></div>
              </div>
            @endif

            <div
              class="w-12 h-12 rounded-full border-2 flex items-center justify-center transition-all duration-500 z-10
                            {{ $isCompleted ? 'bg-gold border-gold text-white shadow-gold' : 'bg-card border-muted text-muted-foreground' }}
                            {{ $isCurrent ? 'ring-4 ring-gold/20 animate-pulse' : '' }}">
              @if ($isCompleted)
                <x-lucide-check class="w-5 h-5 stroke-[3px]" />
              @else
                <span class="text-xs font-black">{{ $index + 1 }}</span>
              @endif
            </div>
            <span
              class="mt-4 text-[10px] font-black uppercase tracking-widest {{ $isCompleted ? 'text-foreground' : 'text-muted-foreground' }}">
              {{ $step }}
            </span>
          </div>
        @endforeach
      </div>
    </div>

    <div class="mb-10">
      <h2 class="text-xs font-black uppercase tracking-[0.3em] text-muted-foreground mb-6 flex items-center gap-2">
        <x-lucide-shopping-cart class="w-4 h-4 text-gold" />
        Consignment Details
      </h2>
      <div class="grid gap-3">
        @foreach ($order->items as $item)
          <div
            class="flex items-center gap-6 p-4 rounded-xl border border-border/50 bg-muted/10 hover:bg-muted/20 transition-colors">
            <div class="w-16 h-16 bg-card rounded-lg border border-border overflow-hidden shadow-sm flex-shrink-0">
              @if ($item->product && !empty($item->product->images))
                <img src="{{ url('storage', $item->product->images[0]) }}" class="w-full h-full object-cover">
              @else
                <div class="w-full h-full flex items-center justify-center bg-muted">
                  <x-lucide-package class="w-6 h-6 text-muted-foreground/30" />
                </div>
              @endif
            </div>
            <div class="flex-1">
              <h3 class="font-bold text-lg font-heading leading-tight">{{ $item->product->name ?? 'Premium Item' }}
              </h3>
              <div class="flex items-center gap-4 mt-1">
                <span
                  class="text-[10px] font-bold text-muted-foreground uppercase tracking-tighter bg-muted px-2 py-0.5 rounded">Qty:
                  {{ $item->quantity }}</span>
                <span
                  class="text-[10px] font-bold text-gold uppercase tracking-widest">{{ Number::currency($item->price, 'NGN') }}
                  each</span>
              </div>
            </div>
            <div class="text-right">
              <div class="text-lg font-bold text-foreground font-heading">
                {{ Number::currency($item->price * $item->quantity, 'NGN') }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <div
    class="bg-muted/30 border border-border rounded-larins p-8 flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="flex items-center gap-5 text-center md:text-left flex-col md:flex-row">
      <div class="w-12 h-12 bg-card rounded-full flex items-center justify-center shadow-soft border border-border">
        <x-lucide-help-circle class="w-6 h-6 text-gold" />
      </div>
      <div>
        <h3 class="font-bold font-heading text-xl">Order Inquiry?</h3>
        <p class="text-sm text-muted-foreground font-body">Our Larins concierge team is available 24/7 to assist you.
        </p>
      </div>
    </div>
    <div class="flex gap-3">
      <a href="/contact"
        class="px-6 py-3 bg-primary text-primary-foreground text-xs font-black uppercase tracking-widest rounded-lg hover:bg-gold-dark transition-all shadow-gold">
        Message Support
      </a>
      <a href="tel:+23400000000"
        class="px-6 py-3 bg-card border border-border text-foreground text-xs font-black uppercase tracking-widest rounded-lg hover:bg-muted transition-all">
        Call Us
      </a>
    </div>
  </div>
</div>

<div
  class="relative overflow-hidden bg-card/30 backdrop-blur-xl rounded-[3.5rem] p-16 md:p-32 border border-dashed border-border/60 text-center shadow-2xl">
  <div
    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-primary/5 blur-[80px] rounded-full -z-10">
  </div>

  <div class="relative inline-flex items-center justify-center w-32 h-32 mb-10">
    <div class="absolute inset-0 bg-gold/5 rounded-full animate-ping opacity-20"></div>
    <div
      class="relative flex items-center justify-center w-full h-full bg-background border border-border rounded-full shadow-inner">
      <x-lucide-shopping-cart class="w-14 h-14 text-muted-foreground/30" />
    </div>
  </div>

  <h2 class="text-4xl font-black italic tracking-tighter uppercase mb-6">
    Your Cart is <span class="text-transparent text-stroke-sm dark:text-stroke-white">Silent</span>
  </h2>
  <p class="text-muted-foreground mb-12 max-w-sm mx-auto font-medium leading-relaxed italic">
    "A curated life begins with a single selection. Discover your next beauty essential today."
  </p>

  <a href="{{ route('shop') }}" wire:navigate
    class="inline-flex items-center gap-4 px-12 py-5 bg-foreground text-background dark:bg-primary dark:text-primary-foreground rounded-2xl font-black uppercase tracking-[0.2em] text-xs transition-all duration-500 hover:scale-105 hover:shadow-2xl active:scale-95 group">
    <x-lucide-sparkles class="w-4 h-4 group-hover:rotate-12 transition-transform" />
    Begin Exploring
  </a>
</div>
