<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     summary="Аутентификация пользователя",
     *     description="Логин с использованием email и пароля, возвращает сообщение об успехе",
     *     tags={"Web"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Успешная аутентификация",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="OK")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неверные данные",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Неверные данные")
     *         )
     *     )
     * )
     */
    public function login(Request $request): JsonResponse
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Неверные данные'], 401);
        }
        $request->session()->regenerate();
        return response()->json(['message' => 'OK']);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Завершение сеанса пользователя",
     *     description="Выход пользователя и инвалидирование сессии",
     *     tags={"Web"},
     *
     *     security={{"sanctumAuth":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Сеанс завершён успешно",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Сеанс завершён")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизован",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        return response()->json(['message' => 'Сеанс завершён']);
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Получить текущего пользователя",
     *     description="Возвращает данные пользователя, авторизованного через сессию или Sanctum",
     *     tags={"API"},
     *
     *     security={{"sanctumAuth":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Данные пользователя",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Иван Иванов"),
     *             @OA\Property(property="email", type="string", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Неавторизован",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized")
     *         )
     *     )
     * )
     */
    public function user(Request $request)
    {
        return $request->user();
    }
}
