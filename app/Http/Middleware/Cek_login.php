<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CekLogin
{
    public function handle(Request $request, Closure $next, $roles)
    {
        // Cek apakah sudah login atau belum. Jika belum, kembali ke halaman login
        if (!Auth::check()) {
            Log::warning('User not authenticated. Redirecting to login.');
            return redirect('login');
        }

        // Simpan data user pada variabel user
        $user = Auth::user();

        // Logging untuk debugging
        Log::info('User is trying to access this page', [
            'user_id' => $user->id, 
            'level_id' => $user->level_id, 
            'roles' => $roles
        ]);

        // Pengecekan tipe data untuk $roles
        if (is_string($roles) || is_numeric($roles)) {
            // Jika user memiliki level sesuai dengan parameter $roles, lanjutkan request
            if ($user->level_id == $roles) {
                Log::info('User has access to this page');
                return $next($request);
            }
        } else {
            Log::error('Invalid roles type', ['roles' => $roles]);
        }

        // Jika tidak memiliki akses, kembalikan ke halaman login dengan pesan error
        Log::warning('User does not have access to this page', [
            'user_id' => $user->id, 
            'required_level' => $roles
        ]);
        return redirect('login')->with('error', 'Anda tidak memiliki akses');
    }
}
