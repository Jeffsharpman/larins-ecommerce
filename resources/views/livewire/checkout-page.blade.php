<div class="min-h-screen bg-background text-foreground transition-colors duration-500 overflow-hidden selection:bg-primary/20 selection:text-primary">
    {{-- Ambient Luxury Backgrounds --}}
    <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-primary/5 blur-[120px] rounded-full -z-10 animate-pulse-slow"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-primary/5 blur-[100px] rounded-full -z-10"></div>

    <div class="max-w-7xl mx-auto px-6 py-20 relative z-10">
        {{-- Header Section --}}
        <div class="mb-16 text-center lg:text-left border-b border-border pb-12">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-primary/10 border border-primary/20 text-primary text-[10px] font-black uppercase tracking-[0.3em] mb-6 animate-in fade-in slide-in-from-top-4 duration-700">
                <x-lucide-lock class="w-3.5 h-3.5" /> Secure Archive Transaction
            </div>
            <h1 class="text-6xl md:text-8xl font-black italic tracking-tighter uppercase leading-none text-foreground">
                Secure <span class="text-primary border-text" style="-webkit-text-stroke: 1.5px currentColor;">Checkout</span>
            </h1>
            <p class="text-muted-foreground text-xs font-bold uppercase tracking-[0.4em] mt-6 opacity-60 italic">Finalize your curated selection</p>
        </div>

        <form wire:submit.prevent="processPayment">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                {{-- Left Column: Forms --}}
                <div class="col-span-12 lg:col-span-7 space-y-10">
                    
                    {{-- Shipping Destination Card --}}
                    <div class="bg-card/50 backdrop-blur-xl rounded-[2.5rem] border border-border p-8 md:p-12 shadow-card relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors duration-700"></div>
                        
                        <div class="flex items-center gap-5 mb-12 pb-8 border-b border-border">
                            <div class="w-14 h-14 rounded-2xl bg-primary text-background flex items-center justify-center shadow-lg shadow-primary/20">
                                <x-lucide-truck class="w-7 h-7" />
                            </div>
                            <div>
                                <h2 class="font-black italic uppercase text-xl tracking-tighter">Shipping</h2>
                                <p class="text-[9px] uppercase tracking-[0.3em] text-muted-foreground font-black">Archive Delivery Location</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            {{-- Input: First Name --}}
                            <div class="space-y-3">
                                <label class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 ml-2" for="first_name">Acquirer Name</label>
                                <div class="relative">
                                    <input wire:model="first_name" id="first_name" type="text" placeholder="First Name"
                                        class="w-full bg-background/50 border-border rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-300 placeholder:opacity-20 font-bold @error('first_name') border-red-500 @enderror">
                                    @error('first_name') <x-lucide-alert-circle class="absolute right-5 top-5 w-5 h-5 text-red-500" /> @enderror
                                </div>
                            </div>

                            {{-- Input: Last Name --}}
                            <div class="space-y-3">
                                <label class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 ml-2" for="last_name">Surname</label>
                                <input wire:model="last_name" id="last_name" type="text" placeholder="Last Name"
                                    class="w-full bg-background/50 border-border rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-bold">
                            </div>

                            {{-- Input: Phone --}}
                            <div class="md:col-span-2 space-y-3">
                                <label class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 ml-2" for="phone">Communication Line</label>
                                <div class="relative group">
                                    <span class="absolute left-6 top-1/2 -translate-y-1/2 text-primary font-black text-sm tracking-tighter">+234</span>
                                    <input wire:model="phone" id="phone" type="tel" placeholder="801 000 0000"
                                        class="w-full bg-background/50 border-border rounded-2xl pl-20 pr-6 py-5 focus:ring-2 focus:ring-primary/20 focus:border-primary font-bold transition-all">
                                </div>
                            </div>

                            {{-- Input: Address --}}
                            <div class="md:col-span-2 space-y-3">
                                <label class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 ml-2" for="address">Street Address</label>
                                <input wire:model="address" id="address" type="text" placeholder="Enter physical address"
                                    class="w-full bg-background/50 border-border rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary/20 focus:border-primary font-bold transition-all">
                            </div>

                            <div class="space-y-3">
                                <label class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 ml-2" for="city">City</label>
                                <input wire:model="city" id="city" type="text" class="w-full bg-background/50 border-border rounded-2xl px-6 py-5 focus:ring-2 focus:ring-primary/20 focus:border-primary font-bold">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-3">
                                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 ml-2" for="state">State</label>
                                    <input wire:model="state" id="state" type="text" class="w-full bg-background/50 border-border rounded-2xl px-6 py-5 font-bold focus:border-primary">
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[9px] font-black uppercase tracking-[0.3em] text-muted-foreground/60 ml-2" for="zip_code">Zip</label>
                                    <input wire:model="zip_code" id="zip_code" type="text" class="w-full bg-background/50 border-border rounded-2xl px-6 py-5 font-bold focus:border-primary">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Method Card --}}
                    <div class="bg-card/50 backdrop-blur-xl rounded-[2.5rem] border border-border p-8 md:p-12 shadow-card relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors duration-700"></div>
                        
                        <div class="flex items-center gap-5 mb-8 pb-6 border-b border-border">
                            <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center border border-primary/20">
                                <x-lucide-package class="w-7 h-7" />
                            </div>
                            <div>
                                <h2 class="font-black italic uppercase text-xl tracking-tighter">Delivery Method</h2>
                                <p class="text-[9px] uppercase tracking-[0.3em] text-muted-foreground font-black">Select Logistics Protocol</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @foreach($shipping_methods as $method)
                                <label class="relative flex items-start gap-6 p-6 border-2 border-border rounded-[2rem] cursor-pointer transition-all duration-500 hover:border-primary/40 group has-[:checked]:border-primary has-[:checked]:bg-primary/5 @error('selected_shipping_method_id') border-red-500 @enderror">
                                    <input wire:model.live="selected_shipping_method_id" type="radio" value="{{ $method->id }}" class="sr-only peer">
                                    <div class="flex justify-between items-start flex-1">
                                        <div class="flex items-start gap-4">
                                            <div class="w-12 h-12 bg-muted rounded-2xl flex items-center justify-center group-hover:bg-primary/10 group-hover:text-primary transition-colors duration-500 @if($method->is_default) ring-2 ring-primary ring-offset-4 ring-offset-background @endif">
                                                <x-lucide-truck class="w-6 h-6" />
                                            </div>
                                            <div class="space-y-1">
                                                <span class="font-black italic uppercase tracking-tighter text-lg block">{{ $method->name }}</span>
                                                <span class="text-[10px] text-muted-foreground font-black uppercase tracking-widest opacity-70">{{ $method->delivery_time }}</span>
                                                @if($method->description)
                                                    <p class="text-[9px] text-muted-foreground font-medium uppercase tracking-wider mt-2">{{ $method->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            @if($method->base_cost == 0)
                                                <span class="text-[10px] font-black uppercase tracking-widest text-primary">Complimentary</span>
                                            @else
                                                <span class="text-lg font-black italic tracking-tighter">{{ Number::currency($method->base_cost, 'NGN') }}</span>
                                            @endif
                                            <div class="w-6 h-6 rounded-full border-2 border-border flex items-center justify-center peer-checked:border-primary peer-checked:bg-primary transition-all duration-500 mt-2 ml-auto">
                                                <div class="w-2.5 h-2.5 rounded-full bg-background opacity-0 peer-checked:opacity-100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Payment Method Card --}}
                    <div class="bg-card/50 backdrop-blur-xl rounded-[2.5rem] border border-border p-8 md:p-12 shadow-card relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-primary/5 rounded-full blur-3xl"></div>
                        
                        <div class="flex items-center gap-5 mb-8 pb-6 border-b border-border">
                            <div class="w-14 h-14 rounded-2xl bg-primary text-background flex items-center justify-center shadow-lg shadow-primary/20">
                                <x-lucide-credit-card class="w-7 h-7" />
                            </div>
                            <div>
                                <h2 class="font-black italic uppercase text-xl tracking-tighter">Payment</h2>
                                <p class="text-[9px] uppercase tracking-[0.3em] text-muted-foreground font-black">Select Payment Method</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Paystack Option --}}
                            <label class="relative flex flex-col p-8 border-2 border-border rounded-[2rem] cursor-pointer transition-all duration-500 hover:border-primary/40 group has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                <input wire:model.live="payment_method" type="radio" value="paystack" class="sr-only peer">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-primary/20 transition-colors">
                                        <svg class="w-8 h-8 text-primary" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                                        </svg>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-border flex items-center justify-center peer-checked:border-primary peer-checked:bg-primary transition-all duration-500">
                                        <div class="w-2.5 h-2.5 rounded-full bg-background opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                </div>
                                <span class="font-black italic uppercase tracking-tighter text-xl mb-2">Paystack</span>
                                <span class="text-[9px] text-muted-foreground font-black uppercase tracking-[0.2em] opacity-60">Nigerian Banks</span>
                                <div class="mt-4 pt-4 border-t border-border/50">
                                    <div class="flex items-center gap-2 text-[9px] text-emerald-500 font-black uppercase tracking-wider">
                                        <x-lucide-check-circle class="w-3 h-3" />
                                        <span>Local Support</span>
                                    </div>
                                </div>
                            </label>

                            {{-- Stripe Option --}}
                            <label class="relative flex flex-col p-8 border-2 border-border rounded-[2rem] cursor-pointer transition-all duration-500 hover:border-primary/40 group has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                                <input wire:model.live="payment_method" type="radio" value="stripe" class="sr-only peer">
                                <div class="flex justify-between items-start mb-6">
                                    <div class="w-16 h-16 bg-[#635BFF]/10 rounded-2xl flex items-center justify-center group-hover:bg-[#635BFF]/20 transition-colors">
                                        <svg class="w-8 h-8 text-[#635BFF]" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.409 0-.831.683-1.305 1.901-1.305 2.227 0 4.515.858 6.09 1.631l.89-5.494C18.252.975 15.697 0 12.165 0 9.667 0 7.589.654 6.104 1.872 4.56 3.147 3.757 4.992 3.757 7.218c0 4.039 2.467 5.76 6.476 7.219 2.585.92 3.445 1.574 3.445 2.583 0 .98-.84 1.545-2.354 1.545-1.875 0-4.965-.921-6.99-2.109l-.9 5.555C5.175 22.99 8.385 24 11.714 24c2.641 0 4.843-.624 6.328-1.813 1.664-1.305 2.525-3.236 2.525-5.732 0-4.128-2.524-5.851-6.591-7.305z"/>
                                        </svg>
                                    </div>
                                    <div class="w-6 h-6 rounded-full border-2 border-border flex items-center justify-center peer-checked:border-[#635BFF] peer-checked:bg-[#635BFF] transition-all duration-500">
                                        <div class="w-2.5 h-2.5 rounded-full bg-background opacity-0 peer-checked:opacity-100"></div>
                                    </div>
                                </div>
                                <span class="font-black italic uppercase tracking-tighter text-xl mb-2">Stripe</span>
                                <span class="text-[9px] text-muted-foreground font-black uppercase tracking-[0.2em] opacity-60">International Cards</span>
                                <div class="mt-4 pt-4 border-t border-border/50">
                                    <div class="flex items-center gap-2 text-[9px] text-[#635BFF] font-black uppercase tracking-wider">
                                        <x-lucide-check-circle class="w-3 h-3" />
                                        <span>Global Cards</span>
                                    </div>
                                </div>
                            </label>
                        </div>

                        {{-- Security Badges --}}
                        <div class="mt-8 pt-8 border-t border-border flex items-center justify-center gap-6 opacity-50">
                            <div class="flex items-center gap-2 text-[9px] font-black uppercase tracking-widest text-muted-foreground">
                                <x-lucide-lock class="w-4 h-4" />
                                <span>256-bit SSL</span>
                            </div>
                            <div class="h-4 w-[1px] bg-border"></div>
                            <div class="flex items-center gap-2 text-[9px] font-black uppercase tracking-widest text-muted-foreground">
                                <x-lucide-shield-check class="w-4 h-4" />
                                <span>PCI Compliant</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Summary --}}
                <aside class="col-span-12 lg:col-span-5 lg:sticky lg:top-24 space-y-8">
                    <div class="bg-card rounded-[3rem] p-10 shadow-card relative overflow-hidden border border-border">
                        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-primary/5 rounded-full blur-3xl opacity-50"></div>
                        
                        <h3 class="text-[10px] font-black uppercase tracking-[0.5em] mb-8 opacity-40 text-center lg:text-left">Order Manifest</h3>
                        
                        {{-- Coupon Section --}}
                        <div class="mb-8 pb-8 border-b border-border">
                            @if($applied_coupon)
                                <div class="flex items-center justify-between p-4 bg-primary/5 border border-primary/20 rounded-2xl">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                                            <x-lucide-tag class="w-5 h-5 text-primary" />
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-black uppercase tracking-widest text-primary block">{{ $applied_coupon->code }}</span>
                                            <span class="text-[9px] text-muted-foreground font-medium uppercase tracking-wider">
                                                @if($applied_coupon->discount_type === 'percentage')
                                                    {{ $applied_coupon->discount_value }}% off
                                                @else
                                                    {{ Number::currency($applied_coupon->discount_value, 'NGN') }} off
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <button wire:click="removeCoupon" type="button" class="text-muted-foreground hover:text-red-500 transition-colors">
                                        <x-lucide-x class="w-5 h-5" />
                                    </button>
                                </div>
                            @else
                                <div class="flex gap-3">
                                    <input wire:model="coupon_code" type="text" placeholder="Enter coupon code"
                                        class="flex-1 bg-background/50 border-border rounded-2xl px-5 py-4 text-[10px] font-bold uppercase tracking-widest focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:opacity-30">
                                    <button wire:click="applyCoupon" type="button"
                                        class="px-6 py-4 bg-primary text-background rounded-2xl font-black uppercase tracking-widest text-[10px] hover:scale-[1.02] active:scale-[0.98] transition-all">
                                        Apply
                                    </button>
                                </div>
                            @endif
                        </div>

                        {{-- Order Totals --}}
                        <div class="space-y-5 mb-8 pb-8 border-b border-border">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black uppercase tracking-[0.3em] opacity-50">Subtotal</span>
                                <span class="text-sm font-black italic tracking-tighter">{{ Number::currency($subtotal, 'NGN') }}</span>
                            </div>
                            
                            @if($discount > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-green-600">Discount</span>
                                    <span class="text-sm font-black italic tracking-tighter text-green-600">-{{ Number::currency($discount, 'NGN') }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black uppercase tracking-[0.3em] opacity-50">Logistics</span>
                                @if($shipping == 0)
                                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-primary">Complimentary</span>
                                @else
                                    <span class="text-sm font-black italic tracking-tighter">{{ Number::currency($shipping, 'NGN') }}</span>
                                @endif
                            </div>
                            
                            @if($tax > 0)
                                <div class="flex justify-between items-center">
                                    <span class="text-[10px] font-black uppercase tracking-[0.3em] opacity-50">Tax</span>
                                    <span class="text-sm font-black italic tracking-tighter">{{ Number::currency($tax, 'NGN') }}</span>
                                </div>
                            @endif
                            
                            <div class="flex justify-between items-center pt-6 border-t border-border">
                                <div>
                                    <span class="text-[9px] font-black uppercase tracking-[0.5em] opacity-40 block mb-2">Total Investment</span>
                                    <span class="text-4xl md:text-5xl font-black italic tracking-tighter text-foreground">{{ Number::currency($grand_total, 'NGN') }}</span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" wire:loading.attr="disabled" wire:target="processPayment"
                            class="w-full py-7 bg-primary text-background rounded-[2rem] font-black uppercase tracking-[0.4em] text-[11px] shadow-2xl shadow-primary/30 transition-all duration-700 hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-4 group disabled:opacity-70">
                            
                            <span wire:loading.remove wire:target="processPayment" class="flex items-center gap-4">
                                <x-lucide-lock class="w-4 h-4" />
                                @if($payment_method === 'stripe')
                                    Proceed to Stripe
                                @else
                                    Proceed to Paystack
                                @endif
                                <x-lucide-arrow-right class="w-4 h-4 group-hover:translate-x-2 transition-transform duration-500" />
                            </span>

                            <div wire:loading.flex wire:target="processPayment" class="items-center gap-3">
                                <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="italic tracking-tighter">Initializing Payment...</span>
                            </div>
                        </button>
                    </div>

                    {{-- Review List --}}
                    <div class="bg-card/20 backdrop-blur-md rounded-[2.5rem] border border-border overflow-hidden">
                        <div class="px-8 py-6 border-b border-border bg-muted/30 flex justify-between items-center">
                            <h3 class="font-black uppercase text-[10px] tracking-[0.4em] opacity-50">Review Gallery</h3>
                            <span class="text-[9px] font-black bg-primary text-background px-3 py-1 rounded-full uppercase tracking-widest">{{ count($cart_items) }} Units</span>
                        </div>
                        <div class="divide-y divide-border max-h-[320px] overflow-y-auto custom-scrollbar">
                            @foreach ($cart_items as $item)
                                <div class="p-6 transition-colors hover:bg-primary/5">
                                    <x-card.item-summary-card :item="$item" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </aside>
            </div>
        </form>
    </div>
</div>
