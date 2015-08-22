<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class Localize implements Middleware {

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        function only($locale, $value) {
            if (is_array($value)) {
                foreach ($value as $key => $_value) {
                  // echo $key.'-';
                    if ($key === 'title' || $key === 'description') {
                        // echo 'in';
                        if (array_key_exists($locale, $value[$key])) {
                            $value[$key] = $value[$key][$locale];
                        } else if (array_key_exists('en', $value[$key])) {
                            $value[$key] = $value[$key]['en'];
                        } else {
                            $value[$key] = null;
                        }
                    } else if (is_array($value[$key])) {
                        $value[$key] = only($locale, $value[$key]);
                    }
                }
            }
            return $value;
        }
        if ($request->input('locale')) {
            $response = json_decode(json_encode($response->original), true);
            $locale = $request->input('locale')?:'en';
            return only($locale, $response);
        }
        return $response;
    }
}
