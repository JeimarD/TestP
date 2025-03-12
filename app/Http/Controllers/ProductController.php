<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotFoundException;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use OpenApi\Annotations as OA;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     summary="Listar todos los productos",
     *     tags={"Productos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de productos con sus monedas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Test Update22"),
     *                 @OA\Property(property="description", type="string", example="Description test update."),
     *                 @OA\Property(property="price", type="number", format="float", example=1000.10),
     *                 @OA\Property(property="currency_id", type="integer", example=1),
     *                 @OA\Property(property="tax_cost", type="number", format="float", example=15.01),
     *                 @OA\Property(property="manufacturing_cost", type="number", format="float", example=357.66),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-12T18:21:39.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-12T20:06:33.000000Z"),
     *                 @OA\Property(
     *                     property="currency",
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="US Dollar"),
     *                     @OA\Property(property="symbol", type="string", example="USD"),
     *                     @OA\Property(property="exchange_rate", type="number", format="float", example=1.0000),
     *                     @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-12T18:21:39.000000Z"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-12T18:21:39.000000Z")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\MediaType(
     *         mediaType="application/json"
     *     )
     * )
     */
    public function index()
    {
        return Product::with('currency')->get();
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     summary="Crear un nuevo producto",
     *     tags={"Productos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "price", "currency_id", "tax_cost", "manufacturing_cost"},
     *             @OA\Property(property="name", type="string", example="Test Create"),
     *             @OA\Property(property="description", type="string", example="Description test create."),
     *             @OA\Property(property="price", type="number", format="float", example=1455.1),
     *             @OA\Property(property="currency_id", type="integer", example=2),
     *             @OA\Property(property="tax_cost", type="number", format="float", example=15.01),
     *             @OA\Property(property="manufacturing_cost", type="number", format="float", example=357.66)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Producto creado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=13),
     *             @OA\Property(property="name", type="string", example="Test Create"),
     *             @OA\Property(property="description", type="string", example="Description test create."),
     *             @OA\Property(property="price", type="number", format="float", example=1455.1),
     *             @OA\Property(property="currency_id", type="integer", example=2),
     *             @OA\Property(property="tax_cost", type="number", format="float", example=15.01),
     *             @OA\Property(property="manufacturing_cost", type="number", format="float", example=357.66),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2025-03-12T20:46:05.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-12T20:46:05.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El campo name es obligatorio."),
     *             @OA\Property(property="errors", type="object", 
     *                 @OA\Property(property="name", type="array", 
     *                     @OA\Items(type="string", example="El campo name es obligatorio.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\MediaType(
     *         mediaType="application/json"
     *     )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        return Product::create($request->validated());
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     summary="Obtener detalles de un producto",
     *     tags={"Productos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del producto",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Test Product"),
     *                 @OA\Property(property="description", type="string", example="Description test"),
     *                 @OA\Property(property="price", type="number", format="float", example=1000.10),
     *                 @OA\Property(property="currency_id", type="integer", example=1),
     *                 @OA\Property(property="currency", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="US Dollar"),
     *                     @OA\Property(property="symbol", type="string", example="USD"),
     *                     @OA\Property(property="exchange_rate", type="string", example="1.0000")
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
    public function show($id)
    {
        $product = Product::with('currency')->find($id);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     summary="Actualizar un producto",
     *     tags={"Productos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Product"),
     *             @OA\Property(property="description", type="string", example="Updated description"),
     *             @OA\Property(property="price", type="number", format="float", example=1200.50),
     *             @OA\Property(property="currency_id", type="integer", example=1),
     *             @OA\Property(property="tax_cost", type="number", format="float", example=20.00),
     *             @OA\Property(property="manufacturing_cost", type="number", format="float", example=400.75)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Producto actualizado exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Updated Product"),
     *             @OA\Property(property="description", type="string", example="Updated description"),
     *             @OA\Property(property="price", type="number", format="float", example=1200.50),
     *             @OA\Property(property="currency_id", type="integer", example=1),
     *             @OA\Property(property="tax_cost", type="number", format="float", example=20.00),
     *             @OA\Property(property="manufacturing_cost", type="number", format="float", example=400.75),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2025-03-12T21:00:00.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Producto no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Producto no encontrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="El campo name es obligatorio."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="El campo name es obligatorio.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\MediaType(
     *         mediaType="application/json"
     *     )
     * )
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $product->update($request->validated());
        return $product;
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     summary="Eliminar un producto",
     *     tags={"Productos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del producto",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Producto eliminado exitosamente"
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
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            throw new ProductNotFoundException();
        }

        $product->delete();
        return response()->noContent();
    }
}
