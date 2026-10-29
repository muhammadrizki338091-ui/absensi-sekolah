<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Guru;
use Symfony\Component\HttpFoundation\Response;

class GuruAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('guru_id')) {
            return redirect()->route('login');
        }

        $guru = Guru::find(session('guru_id'));
        if (!$guru) {
            session()->forget('guru_id');
            return redirect()->route('login');
        }

        view()->share('guru', $guru);

        return $next($request);
    }
}
