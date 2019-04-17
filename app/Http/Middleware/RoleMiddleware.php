<?php
namespace App\Http\Middleware;

use Closure;
use App;
use Auth;

class RoleMiddleware
{    
    public function handle($request, Closure $next)
    {
    	$roles = array_except(func_get_args(), [0,1]);    	
        if (Auth::user() && !in_array(Auth::user()->role,$roles) ) {
            return App::abort(Auth::check() ? 403 : 401, Auth::check() ? 'Forbidden' : 'Unauthorized');
        }

        return $next($request);
    }
}
?>