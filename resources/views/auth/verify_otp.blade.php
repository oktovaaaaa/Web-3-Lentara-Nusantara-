<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP Perangkat Baru — Lentara Nusantara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl space-y-6 relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl pointer-events-none"></div>

        <div class="text-center space-y-2">
            <div class="w-16 h-16 bg-amber-500/10 text-amber-500 border border-amber-500/20 rounded-2xl flex items-center justify-center mx-auto text-3xl font-bold mb-4">
                <i class='bx bx-shield-quarter'></i>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">Verifikasi Perangkat Baru</h1>
            <p class="text-xs text-slate-400 leading-relaxed">
                Login dari perangkat/browser baru terdeteksi. Kode OTP 6-digit telah dikirimkan ke email administrator:
                <span class="block font-bold text-amber-400 mt-1">{{ session('pending_admin_login.email', 'oktovaaaaa@gmail.com') }}</span>
            </p>
        </div>

        @if($errors->any())
            <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl text-xs flex items-center gap-3">
                <i class='bx bx-error-circle text-lg'></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.otp.post') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2 text-center">Masukkan Kode OTP 6-Digit</label>
                <input type="text" name="otp" id="otp" maxlength="6" autofocus placeholder="123456" required
                    class="w-full text-center tracking-[0.5em] text-2xl font-black py-3.5 px-4 rounded-2xl border border-slate-700 bg-slate-800/80 text-white focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent placeholder:tracking-normal placeholder:font-normal placeholder:text-slate-600">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-2xl bg-amber-600 hover:bg-amber-500 text-slate-950 font-black text-sm transition-all shadow-lg shadow-amber-600/20 flex items-center justify-center gap-2">
                <span>Verifikasi & Masuk Dashboard</span>
                <i class='bx bx-right-arrow-alt text-xl'></i>
            </button>
        </form>

        <div class="text-center pt-2 border-t border-slate-800/80 flex items-center justify-between text-xs text-slate-500">
            <a href="{{ route('login') }}" class="hover:text-slate-300 transition-colors flex items-center gap-1">
                <i class='bx bx-left-arrow-alt'></i> Balik ke Login
            </a>
            <form action="{{ route('login.otp.resend') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-amber-500 hover:underline font-bold">Kirim Ulang OTP</button>
            </form>
        </div>

    </div>

</body>
</html>
