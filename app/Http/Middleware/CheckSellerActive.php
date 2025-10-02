<?php

namespace App\Http\Middleware;

use App\Models\Seller;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckSellerActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $seller = Auth::user();

        if (!$seller) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }

        // Check seller status and redirect accordingly
        if ($seller->status !== Seller::STATUS_APPROVED) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Redirect to appropriate inactive page based on status
            switch ($seller->status) {
                case Seller::STATUS_PENDING:
                    return redirect()->route('sellers.pending');
                case Seller::STATUS_SUSPENDED:
                    return redirect()->route('sellers.suspended');
                case Seller::STATUS_REJECTED:
                    return redirect()->route('sellers.rejected');
                default:
                    return redirect()->route('login')->with('error', 'Account status unknown. Please contact support.');
            }
        }

        return $next($request);
    }
}
