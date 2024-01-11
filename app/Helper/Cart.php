<?php

namespace App\Helper;

use App\Models\CartItem;
use Illuminate\Support\Facades\Cookie;

class Cart {
    public static function getCount()
    {
        if ($user = auth()->user()) {
            return CartItem::whereUserId($user->id)->sum('quantity');
        }
    }

    public static function getCartItems()
    {
        if ($user = auth()->user()) {
            return CartItem::whereUserId($user->id)->get()->map(fn(CartItem $item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]);
        }
    }

    public static function getCookieCartItems()
    {
        return json_decode(request()->cookie('cart_items', '[]'), true);
    }

    public static function setCookieCartItems(array $cartItems)
    {
        //Cookie::queue('cart_items', fn(int $carry, array $item) => $carry + $item['quantity'], 0);
        Cookie::queue('cart_items', json_encode($cartItems), 60*24*30);
    }

    public static function saveCookieCartItems()
    {
        $user = auth()->user();
        $userCartItems = CartItem::where('user_id', $user->id)->get()->keyBy('product_id');
        $savedCartItems = [];

        $cartItems = self::getCartItems(); // lesson 11 TIME 22:15
        foreach ($cartItems as $cartItem) {
            if (isset($userCartItems[$cartItem['product_id']])) {
                $userCartItems[$cartItem['product_id']]->update(['quantity' => $cartItem['quantity']]);
                continue;
            }
            $savedCartItems[] = [
                'user_id' => $user->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity']
            ];
        }
        if (!empty($savedCartItems)) {
            CartItem::insert($savedCartItems);
        }
    }

    public static function moveCartItemsIntoDb()
    {
        $request = request();
        $cartItems = self::getCookieCartItems();
        $newCartItems = [];
        foreach ($cartItems as $cartItem) {
            //check if the record already exists
            $existingCartItem = CartItem::where([
                'user_id' => $request->user()->id,
                'product_id' => $cartItem['product_id'],
            ])->first();

            if (!$existingCartItem) {
                //insert only if it doesn't already exist
                $newCartItems[] = [
                    'user_id' => $request->user()->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                ];
            }
        }

        if (!empty($newCartItems)) {
            CartItem::insert($newCartItems);
        }

    }
}
