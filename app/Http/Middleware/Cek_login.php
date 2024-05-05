<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Cek_login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    
    public function handle(Request $request, Closure $next, $roles){
        // cek sudah login atau belum. Jika belum kembali ke halaman login
        if (!Auth::check()){
            return redirect('login');
        }
        
        //simpan data user pada variabel user
        $user = Auth::user();

        Log::info('User is trying to access this page');

        // jika user memiliki level sesuai pada kolom lanjutkan request
        if($user->level_id == $roles){
            Log::info('User has access to this page');
            return $next($request);
        }

        //jika tidak memiliki akses maka kembalikan ke halaman login
        return redirect('login')->with('error', 'Anda tidak memiliki akses');
    }
}
