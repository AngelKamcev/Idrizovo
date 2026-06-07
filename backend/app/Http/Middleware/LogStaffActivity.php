<?php

namespace App\Http\Middleware;

use App\Services\ActivityLogService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogStaffActivity
{
    private const MUTATING_METHODS = ['POST', 'PUT', 'PATCH', 'DELETE'];

    public function __construct(
        private ActivityLogService $activityLog,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->is('admin*') || ! in_array($request->method(), self::MUTATING_METHODS, true)) {
            return $response;
        }

        $user = $request->user();
        if (! $user || ! $user->role) {
            return $response;
        }

        if (! in_array($user->role->name, ['admin', 'vospituvac', 'reviewer'], true)) {
            return $response;
        }

        if (! $response->isSuccessful() && ! $response->isRedirection()) {
            return $response;
        }

        if ($request->routeIs('admin.translate')) {
            return $response;
        }

        $this->activityLog->logStaffAction(
            user: $user,
            request: $request,
            description: $this->activityLog->describeStaffRequest($request),
        );

        return $response;
    }
}
