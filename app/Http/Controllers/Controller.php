<?php

namespace App\Http\Controllers;

use App\Http\Requests\FooRequest;
use App\Jobs\BarJob;
use App\Models\User;
use Illuminate\HTTP\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getToken(): JsonResponse
    {
        $user = User::firstOrNew(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]
        );

        $token = $user->createToken('default_token');

        return response()->json(['token' => $token->plainTextToken]);
    }

    public function acceptJob(FooRequest $request): Response
    {
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ];

        BarJob::dispatch($data);

        return response()->noContent();
    }
}
