<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertUTF8SpecialChar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $tempRequest = [];
        // $oldRequest = $request->all();
        foreach ($request->all() as $key => $value) {
            if (is_string($value)) {
                $val = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', trim($value));
            } else {
                $val = $value;
            }
            $tempRequest[$key] = $val;
        }
        $request->only([]);
        $request->merge($tempRequest);
        // dd($oldRequest, $request->all());

        return $next($request);
    }
}
