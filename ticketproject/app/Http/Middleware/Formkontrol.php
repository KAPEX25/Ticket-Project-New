<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormKontrol
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Yöntem: Request objesinden al
        if (empty($request->metin)) {
            return redirect()->back();
        }
        return $next($request);
    }
}
