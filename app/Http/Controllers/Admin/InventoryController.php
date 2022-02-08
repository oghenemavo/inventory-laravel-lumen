<?php

namespace App\Http\Controllers\Admin;

use App\Models\Inventory;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class InventoryController extends Controller
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

    public function create(Request $request)
    {
        $rules = [
            'name' => 'required|min:2',
            'price' => 'required|min:2',
            'quantity' => 'required|min:2',
        ];

        $this->validate($request, $rules);

        $stock = Inventory::create($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $stock,
            'mesage' => 'inventory created successfully',
        ], 201);
    }
    
    public function read($id)
    {
        $inventory = Inventory::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'data' => $inventory,
            'mesage' => 'inventory fetched successfully',
        ], 200);

    }
    
    public function all()
    {
        return response()->json([
            'status' => 'success',
            'data' => Inventory::all(),
            'mesage' => 'inventories fetched successfully',
        ], 200);

    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $rules = [
            'name' => 'required|min:2',
            'price' => 'required|min:2',
            'quantity' => 'required|min:2',
        ];

        $this->validate($request, $rules);

        $inventory->name = $request->input('name');
        $inventory->price = $request->input('price');
        $inventory->quantity = $request->input('quantity');

        $stock = $inventory->save();

        return response()->json([
            'status' => 'success',
            'data' => $stock,
            'mesage' => 'Inventory updated successfully',
        ], 200);
    }
    
    public function delete($id)
    {    
        $stock = Inventory::findOrFail($id)->delete();
    
        return response()->json([
            'status' => 'success',
            'data' => $stock,
            'mesage' => 'Inventory deleted successfully',
        ], 200);

    }
}
