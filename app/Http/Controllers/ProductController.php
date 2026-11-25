<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /** Listado del catálogo. */
    public function index()
    {
        return ProductResource::collection(Product::with('category')->orderBy('title')->get());
    }

    /** Añadir una ficha al catálogo. */
    public function store(Request $request)
    {
        $product = Product::create($this->validated($request));

        return (new ProductResource($product->load('category')))->response()->setStatusCode(201);
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load('category'));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request, $product));

        return new ProductResource($product->load('category'));
    }

    public function destroy(Product $product)
    {
        // Si algún usuario lo tiene en su colección, no se puede borrar del catálogo
        if ($product->items()->exists()) {
            return response()->json(['message' => 'No se puede eliminar: hay usuarios que tienen este producto en su colección.'], 409);
        }

        $product->delete();

        return response()->noContent();
    }

    /** Valida los datos. La web envía "category" con el nombre; aquí se convierte en category_id. */
    private function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'barcode' => ['required', 'string', 'max:20', Rule::unique('products', 'barcode')->ignore($product?->id)],
            'title' => ['required', 'string', 'max:255'],
            'platform' => ['nullable', 'string', 'max:255'],
            'author_publisher' => ['nullable', 'string', 'max:255'],
            'release_year' => ['nullable', 'integer', 'between:1901,2155'],
            'cover_url' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:30'],
            'status' => ['sometimes', Rule::in(['published', 'pending', 'review'])],
            'category' => ['required', 'exists:categories,name'],
        ]);

        $data['category_id'] = Category::where('name', $data['category'])->value('id');
        unset($data['category']);

        return $data;
    }
}
