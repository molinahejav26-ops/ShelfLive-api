<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    /** Ítems de todos los usuarios. */
    public function index()
    {
        return ItemResource::collection(Item::with(['product', 'user'])->orderBy('id')->get());
    }

    public function store(Request $request)
    {
        $item = Item::create($this->validated($request));

        return (new ItemResource($item->load(['product', 'user'])))->response()->setStatusCode(201);
    }

    public function show(Item $item)
    {
        return new ItemResource($item->load(['product', 'user']));
    }

    public function update(Request $request, Item $item)
    {
        $item->update($this->validated($request));

        return new ItemResource($item->load(['product', 'user']));
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return response()->noContent();
    }

    /**
     * Valida los datos. La web envía "product" (título) y "user" (nombre) de elementos que ya existen
     * y "price"; aquí se convierten en product_id, user_id y purchase_price.
     */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'product' => ['required', 'exists:products,title'],
            'user' => ['required', 'exists:users,name'],
            'state' => ['required', Rule::in(['new', 'used'])],
            'price' => ['nullable', 'numeric', 'min:0'],
            'estimated_value' => ['nullable', 'numeric', 'min:0'],
            'format' => ['sometimes', Rule::in(['physical', 'digital'])],
            'acquired_at' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $data['product_id'] = Product::where('title', $data['product'])->value('id');
        $data['user_id'] = User::where('name', $data['user'])->value('id');
        if (array_key_exists('price', $data)) {
            $data['purchase_price'] = $data['price'];
        }
        unset($data['product'], $data['user'], $data['price']);

        return $data;
    }
}
