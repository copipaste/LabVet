<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $user = $request->user();
        $roles = $user ? $user->getRoleNames()->toArray() : [];

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'roles' => $roles,
            ],
        ];
    }
}
