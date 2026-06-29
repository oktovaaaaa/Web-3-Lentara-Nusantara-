<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class PlayerAuthController extends Controller
{
    public function showRegister()
    {
        return view('player.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => ['required','string','min:3','max:20','alpha_dash','unique:players,username'],
            'pin'      => ['required','digits:4'],
        ], [
            'username.alpha_dash' => 'Username hanya boleh huruf/angka/underscore/dash.',
            'pin.digits' => 'PIN harus 4 digit angka.',
        ]);

        $player = Player::create([
            'username'   => $data['username'],
            'pin_hash'   => Hash::make($data['pin']),
            'nickname'   => $data['username'],
            'avatar_key' => 1,
            'xp_total'   => 0,
            'coins'      => 100,
            'hearts'     => 5,
            'hearts_max' => 5,
        ]);

        Auth::guard('player')->login($player);
        $request->session()->regenerate();

        return redirect()->route('game.learn')->with('success', 'Akun berhasil dibuat. Selamat bermain!');
    }

    public function showLogin()
    {
        return view('player.auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => ['required','string'],
            'pin'      => ['required','digits:4'],
        ], [
            'pin.digits' => 'PIN harus 4 digit angka.',
        ]);

        $player = Player::where('username', $data['username'])->first();

        if (!$player || !Hash::check($data['pin'], $player->pin_hash)) {
            return back()->withErrors(['username' => 'Username atau PIN salah.'])->withInput();
        }

        Auth::guard('player')->login($player);
        $request->session()->regenerate();

        return redirect()->route('game.learn');
    }
    public function loginWithGoogle(Request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Google Auth Error: ' . $e->getMessage(), [
                'exception' => $e
            ]);
            return redirect()->route('player.login')->withErrors(['username' => 'Gagal mengambil data dari Google.']);
        }

        // Cari player berdasarkan google_id atau email
        $player = Player::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($player) {
            // Jika email terdeteksi tetapi google_id belum terisi (misal daftar manual sebelumnya dengan email sama), update google_id nya
            if (!$player->google_id) {
                $player->update(['google_id' => $googleUser->getId()]);
            }

            Auth::guard('player')->login($player);
            $request->session()->regenerate();
            return redirect()->route('game.learn')->with('success', 'Berhasil masuk dengan Google!');
        }

        // Generate suggested username dari nama Google
        $cleanName = preg_replace('/[^a-zA-Z0-9 ]/', '', $googleUser->getName() ?? 'user');
        $suggested_username = strtolower(str_replace(' ', '_', $cleanName));
        if (empty($suggested_username)) {
            $suggested_username = 'user_' . rand(1000, 9999);
        }
        
        while (Player::where('username', $suggested_username)->exists()) {
            $suggested_username .= rand(0, 9);
        }

        // Simpan data Google ke session untuk pendaftaran PIN
        $request->session()->put('google_id', $googleUser->getId());
        $request->session()->put('google_email', $googleUser->getEmail());
        $request->session()->put('google_nickname', $googleUser->getName());
        $request->session()->put('google_suggested_username', $suggested_username);

        return redirect()->route('player.google.complete', [
            'google_id' => $googleUser->getId(),
            'email' => $googleUser->getEmail(),
            'nickname' => $googleUser->getName(),
            'suggested_username' => $suggested_username
        ]);
    }

    public function showGoogleComplete(Request $request)
    {
        $google_id = $request->query('google_id', $request->session()->get('google_id'));
        $email = $request->query('email', $request->session()->get('google_email'));
        $nickname = $request->query('nickname', $request->session()->get('google_nickname'));
        $suggested_username = $request->query('suggested_username', $request->session()->get('google_suggested_username'));

        if (!$google_id || !$email || !$nickname) {
            return redirect()->route('player.login')->withErrors(['username' => 'Sesi pendaftaran Google telah berakhir. Silakan coba kembali.']);
        }

        return view('player.auth.google_complete', compact('google_id', 'email', 'nickname', 'suggested_username'));
    }

    public function completeGoogle(Request $request)
    {
        $data = $request->validate([
            'username'  => ['required','string','min:3','max:20','alpha_dash','unique:players,username'],
            'pin'       => ['required','digits:4'],
            'email'     => ['required','string','email','unique:players,email'],
            'nickname'  => ['required','string'],
            'google_id' => ['required','string','unique:players,google_id'],
        ], [
            'username.alpha_dash' => 'Username hanya boleh huruf/angka/underscore/dash.',
            'pin.digits' => 'PIN harus 4 digit angka.',
        ]);

        $player = Player::create([
            'username'   => $data['username'],
            'pin_hash'   => Hash::make($data['pin']),
            'nickname'   => $data['nickname'],
            'email'      => $data['email'],
            'google_id'  => $data['google_id'],
            'avatar_key' => 1,
            'xp_total'   => 0,
            'coins'      => 100,
            'hearts'     => 5,
            'hearts_max' => 5,
        ]);

        Auth::guard('player')->login($player);
        $request->session()->regenerate();

        $request->session()->forget(['google_id', 'google_email', 'google_nickname', 'google_suggested_username']);

        return redirect()->route('game.learn')->with('success', 'Pendaftaran akun Google berhasil. Selamat bermain!');
    }

    public function logout(Request $request)
    {
        Auth::guard('player')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
