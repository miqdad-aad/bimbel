<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = \App\Models\User::where('email', $request->email)->orWhere('username', $request->email)->first();
        if ($user->role == '1') {
            return redirect('homeAdmin');
        } elseif ($user->role == '2') {
            return redirect('homeMentor');
        }elseif($user->role == '3'){
            return redirect('homeSiswa');

        }
        return $next($request);
    }
}
