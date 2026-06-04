<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only log admin routes
        if (!$request->is('admin*')) {
            return $response;
        }

        $user     = $request->user();
        $method   = $request->method();
        $path     = $request->path();
        $ip       = $request->ip();
        $time     = now()->format('Y-m-d H:i:s');
        $status   = $response->getStatusCode();

        // Build user info
        if ($user) {
            $userName = $user->name ?? $user->email ?? 'Unknown';
            $role     = optional($user->role)->name ?? 'unknown';
            $userInfo = "{$userName} [{$role}]";
        } else {
            $userInfo = 'Guest';
        }

        // Build a human-readable description for POST/PATCH/DELETE
        $action = '';
        if (in_array($method, ['POST', 'PATCH', 'PUT', 'DELETE'])) {
            $action = self::describeAction($method, $path, $request);
        }

        $line = "[{$time}] {$method} /{$path} | {$status} | IP: {$ip} | User: {$userInfo}";
        if ($action) {
            $line .= " | Action: {$action}";
        }
        $line .= PHP_EOL;

        $logPath = storage_path('logs/activity.log');
        file_put_contents($logPath, $line, FILE_APPEND | LOCK_EX);

        return $response;
    }

    private static function describeAction(string $method, string $path, Request $request): string
    {
        // Map common patterns to friendly descriptions
        $patterns = [
            'admin/login'                   => 'Login attempt',
            'admin/logout'                  => 'Logged out',
            'admin/settings/password'       => 'Changed password',
            'admin/settings/users'          => 'Created/updated user',
            'admin/announcements'           => 'Saved announcement',
            'admin/gallery'                 => 'Saved gallery image',
            'admin/aboutus'                 => 'Updated About Us page',
            'admin/izrabotki'               => 'Updated Izrabotki page',
            'admin/visit-schedules'         => 'Saved visit schedule',
            'admin/visit-requests'          => 'Updated visit request',
            'admin/complaints'              => 'Updated complaint',
            'admin/compliments'             => 'Updated compliment',
            'admin/main-activities'         => 'Saved activity',
            'admin/translate'               => 'Ran AI translation',
        ];

        foreach ($patterns as $pattern => $desc) {
            if (str_contains($path, $pattern)) {
                if ($method === 'DELETE') {
                    return 'Deleted: ' . $desc;
                }
                return $desc;
            }
        }

        return ucfirst(strtolower($method)) . ' ' . $path;
    }
}
