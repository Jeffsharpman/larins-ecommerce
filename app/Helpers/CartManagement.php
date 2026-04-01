<?php

namespace App\Helpers;

use App\Models\Coupon;
use App\Models\Product;
use App\Settings\ShippingSettings;
use App\Settings\TaxSettings;
use Illuminate\Support\Facades\Cookie;

class CartManagement
{
    public static function addItemToCart($product_id, $qty = 1)
    {
        $cart_items = self::getCartItemsFromCookie();
        $existing_item_key = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item_key = $key;
                break;
            }
        }

        if ($existing_item_key !== null) {
            $cart_items[$existing_item_key]['quantity'] += ($qty == 1) ? 1 : $qty;
            $cart_items[$existing_item_key]['total_amount'] = $cart_items[$existing_item_key]['quantity'] * $cart_items[$existing_item_key]['unit_amount'];
        } else {
            $product = Product::find($product_id, ['id', 'name', 'price', 'images']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'image' => $product->images[0] ?? null,
                    'quantity' => $qty,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price * $qty,
                ];
            }
        }

        self::addCartItemToCookie($cart_items);

        return count($cart_items);
    }

    public static function addItemToCartWithQty($product_id, $qty = 1)
    {
        $cart_items = self::getCartItemsFromCookie();

        $existing_item = null;

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $existing_item = $key;
                break;
            }
        }

        if ($existing_item !== null) {
            $cart_items[$existing_item]['quantity'] = $qty;
            $cart_items[$existing_item]['total_amount'] = $cart_items[$existing_item]['quantity'] * $cart_items[$existing_item]['unit_amount'];
        } else {
            $product = Product::where('id', $product_id)->first(['id', 'name', 'price', 'images']);
            if ($product) {
                $cart_items[] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'image' => $product->images[0],
                    'quantity' => $qty,
                    'unit_amount' => $product->price,
                    'total_amount' => $product->price,
                ];
            }
        }

        self::addCartItemToCookie($cart_items);

        return count($cart_items);
    }

    public static function removeCartItem($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                unset($cart_items[$key]);
            }
        }

        self::addCartItemToCookie(array_values($cart_items));

        return $cart_items;
    }

    public static function addCartItemToCookie($cart_items)
    {
        Cookie::queue('cart_items', json_encode($cart_items), 60 * 24 * 30);
    }

    public static function getCartItemsFromCookie()
    {
        $cart_items = json_decode(Cookie::get('cart_items'), true);

        return $cart_items ?: [];
    }

    public static function clearCartItems()
    {
        Cookie::queue(Cookie::forget('cart_items'));
        Cookie::queue(Cookie::forget('coupon_code'));
    }

    public static function incrementQuantity($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$key]['quantity']++;
                $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
            }
        }

        self::addCartItemToCookie($cart_items);

        return $cart_items;
    }

    public static function decrementQuantity($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();

        foreach ($cart_items as $key => $item) {
            if ($item['product_id'] == $product_id) {
                if ($cart_items[$key]['quantity'] > 1) {
                    $cart_items[$key]['quantity']--;
                    $cart_items[$key]['total_amount'] = $cart_items[$key]['quantity'] * $cart_items[$key]['unit_amount'];
                }
            }
        }

        self::addCartItemToCookie($cart_items);

        return $cart_items;
    }

    public static function calculateGrandTotal($items)
    {
        return array_sum(array_column($items, 'total_amount'));
    }

    public static function getSubtotal($items)
    {
        return self::calculateGrandTotal($items);
    }

    public static function getCouponCode()
    {
        return Cookie::get('coupon_code');
    }

    public static function applyCoupon($code)
    {
        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon || ! $coupon->isValid()) {
            return ['success' => false, 'message' => 'Invalid or expired coupon code'];
        }

        Cookie::queue('coupon_code', $code, 60 * 24 * 30);

        return ['success' => true, 'coupon' => $coupon, 'message' => 'Coupon applied successfully'];
    }

    public static function removeCoupon()
    {
        Cookie::queue(Cookie::forget('coupon_code'));
    }

    public static function getCouponDiscount($subtotal)
    {
        $code = self::getCouponCode();
        if (! $code) {
            return 0;
        }

        $coupon = Coupon::where('code', $code)->first();
        if (! $coupon || ! $coupon->isValid()) {
            return 0;
        }

        return $coupon->calculateDiscount($subtotal);
    }

    public static function getShippingCost($items)
    {
        $shippingSetting = app(ShippingSettings::class);

        if (! $shippingSetting->enable_shipping) {
            return 0;
        }

        $subtotal = self::calculateGrandTotal($items);

        if ($shippingSetting->free_shipping_enabled && $shippingSetting->free_shipping_threshold) {
            if ($subtotal >= $shippingSetting->free_shipping_threshold) {
                return 0;
            }
        }

        return $shippingSetting->default_shipping_cost ?? 0;
    }

    public static function getTaxAmount($subtotal, $discount = 0)
    {
        $taxSetting = app(TaxSettings::class);

        if (! $taxSetting->tax_enabled) {
            return 0;
        }

        $amount = $subtotal - $discount;

        if ($taxSetting->tax_inclusive === 'exclusive') {
            return ($amount * $taxSetting->default_tax_rate) / 100;
        }

        return 0;
    }

    public static function calculateTotal($items)
    {
        $subtotal = self::calculateGrandTotal($items);
        $discount = self::getCouponDiscount($subtotal);
        $shipping = self::getShippingCost($items);
        $tax = self::getTaxAmount($subtotal, $discount);
        $afterDiscount = $subtotal - $discount;

        return [
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $afterDiscount + $shipping + $tax,
        ];
    }

    public static function calculateTotalSummary($items)
    {
        return self::calculateTotal($items);
    }

    // ============ Wishlist Management ============

    public static function addToWishlist($product_id)
    {
        $wishlist = self::getWishlistFromCookie();

        if (! in_array($product_id, $wishlist)) {
            $wishlist[] = $product_id;
        }

        self::addWishlistToCookie($wishlist);

        return count($wishlist);
    }

    public static function removeFromWishlist($product_id)
    {
        $wishlist = self::getWishlistFromCookie();

        $wishlist = array_filter($wishlist, fn ($id) => $id != $product_id);

        self::addWishlistToCookie(array_values($wishlist));

        return count($wishlist);
    }

    public static function isInWishlist($product_id): bool
    {
        $wishlist = self::getWishlistFromCookie();

        return in_array($product_id, $wishlist);
    }

    public static function addWishlistToCookie($wishlist)
    {
        Cookie::queue('wishlist', json_encode($wishlist), 60 * 24 * 30);
    }

    public static function getWishlistFromCookie()
    {
        $wishlist = json_decode(Cookie::get('wishlist'), true);

        return $wishlist ?: [];
    }

    public static function clearWishlist()
    {
        Cookie::queue(Cookie::forget('wishlist'));
    }

    public static function getWishlistProducts()
    {
        $wishlist = self::getWishlistFromCookie();

        if (empty($wishlist)) {
            return collect([]);
        }

        return Product::whereIn('id', $wishlist)->get();
    }
}
