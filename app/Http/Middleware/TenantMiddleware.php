<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Stancl\Tenancy\Tenancy;
use Stancl\Tenancy\Resolvers\DomainTenantResolver;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // $tenant = Tenant::where('domain', $request->getHost())->first();

        // if ($tenant) {
        //     tenancy()->initialize($tenant);
        // }

        $tenant = app(DomainTenantResolver::class)->resolve($request->getHost());
        dd($tenant);

        if (!$tenant) {
            return response()->json(['error' => 'Tenant not found for domain ' . $request->getHost()], 404);
        }

        // Initialize the found tenant
        tenancy()->initialize($tenant);

        return $next($request);
    }
}
