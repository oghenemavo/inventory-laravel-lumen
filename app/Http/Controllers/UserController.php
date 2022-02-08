<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Inventory;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function inventories()
    {
        return response()->json([
            'status' => 'success',
            'data' => Inventory::all(),
            'mesage' => 'inventories fetched successfully',
        ], 200);
    }

    public function addToCart(Request $request) {
        $rules = [
            'product_id' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
        ];

        $this->validate($request, $rules);

        $inventory = Inventory::find($request->product_id);
        
        if ($inventory && ($request->quantity <= $inventory->quantity)) {
            $addToCart = [
                'user_id' => auth()->user()->id,
                'inventory_id' => $inventory->id,
                'quantity' => $request->quantity,
            ];

            $result = Cart::insert($addToCart);

            if ($result) {
                $inventory->quantity -= $request->quantity;
                $inventory->save();
            }
    
            return response()->json([
                'status' => 'success',
                'data' => $result,
                'mesage' => 'Inventories added to cart successfully',
            ], 201);
        }

        return response()->json([
            'status' => 'fail',
            'mesage' => 'Unable to add inventory to cart',
        ], 401);
    }

}
