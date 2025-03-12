<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotFoundException;
use App\Http\Requests\StoreProductPriceRequest;
use App\Models\Product;
use OpenApi\Annotations as OA;

class ProductPriceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products/{id}/prices",
     *     summary="Obtener los precios de un producto en diferentes monedas",
     *     tags={"Productos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de precios del producto en distintas monedas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=19),
     *                 @OA\Property(property="product_id", type="integer", example=10),
     *                 @OA\Property(property="currency_id", type="integer", example=1),
     *                 @OA\Property(property="price", type="string", example="0.15"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-12T18:21:39.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-12T18:21:39.000000Z"),
     *                 @OA\Property(property="currency", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="US Dollar"),
     *                     @OA\Property(property="symbol", type="string", example="USD"),
     *                     @OA\Property(property="exchange_rate", type="string", example="1.0000"),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-12T18:21:39.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-12T18:21:39.000000Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Producto no encontrado")
     *         )
     *     )
     * )
     */
    public function index($id)
    {
        $product = Product::with('currency')->find($id);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        return $product->prices()->with('currency')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/products/{id}/prices",
     *     summary="Agregar un precio a un producto",
     *     tags={"Productos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer", example=6)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"currency_id", "price"},
     *             @OA\Property(property="currency_id", type="integer", example=1),
     *             @OA\Property(property="price", type="string", example="2000")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Precio agregado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=31),
     *             @OA\Property(property="product_id", type="integer", example=6),
     *             @OA\Property(property="currency_id", type="integer", example=2),
     *             @OA\Property(property="price", type="string", example="2000"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-12T20:52:36.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-12T20:52:36.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El precio es obligatorio"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="price", type="array",
     *                     @OA\Items(type="string", example="El precio debe ser un número")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Producto no encontrado")
     *         )
     *     )
     * )
     */
    public function store(StoreProductPriceRequest $request, Product $product)
    {
        return $product->prices()->create($request->validated());
    }
}
