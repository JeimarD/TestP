<?php

declare(strict_types=1);

/**
 * @OA\Info(
 *     title="API de Productos",
 *     version="1.0.0",
 *     description="API para gestión de productos y precios",
 *     @OA\Contact(
 *         email="soporte@tudominio.com"
 *     )
 * )
 * 
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Servidor Local"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\Tag(
 *     name="Productos",
 *     description="Operaciones con productos"
 * )
 * 
 * @OA\Tag(
 *     name="Precios",
 *     description="Gestión de precios de productos"
 * )
 * 
 * @OA\Tag(
 *     name="Autenticación",
 *     description="Registro y login de usuarios"
 * )
 */
/**
 * @OA\Schema(
 *     schema="RegisterRequest",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="password", type="string", format="password", minLength=6, example="secret")
 * )
 * 
 * @OA\Schema(
 *     schema="LoginRequest",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="secret")
 * )
 * 
 * @OA\Schema(
 *     schema="AuthToken",
 *     @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
 *     @OA\Property(property="token_type", type="string", example="bearer"),
 *     @OA\Property(property="expires_in", type="integer", example=3600)
 * )
 */