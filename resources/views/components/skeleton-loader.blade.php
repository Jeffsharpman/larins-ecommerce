<div {{ $attributes->merge(['class' => 'animate-pulse']) }}>
    @switch($type)
        @case('card')
            <div class="bg-card border border-border rounded-[2.5rem] overflow-hidden">
                <div class="aspect-[4/5] bg-muted"></div>
                <div class="p-6 space-y-4">
                    <div class="h-3 bg-muted rounded w-1/4"></div>
                    <div class="h-6 bg-muted rounded w-3/4"></div>
                    <div class="h-4 bg-muted rounded w-1/2"></div>
                </div>
            </div>
            @break

        @case('product')
            <div class="flex gap-6 p-6 bg-card border border-border rounded-[2.5rem]">
                <div class="w-24 h-24 bg-muted rounded-[1.5rem] shrink-0"></div>
                <div class="flex-1 space-y-3">
                    <div class="h-3 bg-muted rounded w-1/6"></div>
                    <div class="h-5 bg-muted rounded w-3/4"></div>
                    <div class="h-4 bg-muted rounded w-1/3"></div>
                </div>
            </div>
            @break

        @case('order')
            <div class="bg-card border border-border rounded-[2rem] p-8 space-y-6">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 bg-muted rounded-[2rem]"></div>
                    <div class="flex-1 space-y-3">
                        <div class="h-3 bg-muted rounded w-1/5"></div>
                        <div class="h-6 bg-muted rounded w-1/2"></div>
                        <div class="h-4 bg-muted rounded w-1/3"></div>
                    </div>
                </div>
            </div>
            @break

        @case('address')
            <div class="bg-card border border-border rounded-[2rem] p-6 space-y-4">
                <div class="h-3 bg-muted rounded w-1/4"></div>
                <div class="h-5 bg-muted rounded w-3/5"></div>
                <div class="h-4 bg-muted rounded w-4/5"></div>
            </div>
            @break

        @case('text')
            <div class="space-y-3">
                <div class="h-4 bg-muted rounded w-full"></div>
                <div class="h-4 bg-muted rounded w-5/6"></div>
                <div class="h-4 bg-muted rounded w-4/6"></div>
                <div class="h-4 bg-muted rounded w-3/6"></div>
            </div>
            @break

        @case('profile')
            <div class="bg-card border border-border rounded-[3rem] p-10 space-y-8">
                <div class="flex items-center gap-8">
                    <div class="w-28 h-28 bg-muted rounded-full"></div>
                    <div class="flex-1 space-y-4">
                        <div class="h-8 bg-muted rounded w-1/3"></div>
                        <div class="h-3 bg-muted rounded w-1/5"></div>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="h-12 bg-muted rounded-2xl"></div>
                    <div class="h-12 bg-muted rounded-2xl"></div>
                    <div class="h-12 bg-muted rounded-2xl md:col-span-2"></div>
                </div>
            </div>
            @break

        @default
            <div class="h-4 bg-muted rounded w-full"></div>
    @endswitch
</div>
