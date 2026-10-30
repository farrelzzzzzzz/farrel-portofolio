<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP — Farrel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        darkBg: '#0b0b0f',
                        cardBg: '#13131a',
                        cardBorder: '#232330',
                        accentRed: '#e50914',
                        accentRedHover: '#f40612',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-darkBg text-gray-100 font-sans antialiased flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full mx-4 bg-cardBg border border-cardBorder rounded-3xl p-8 shadow-2xl relative">
        <div class="text-center mb-8">
            <a href="/" class="text-2xl font-black tracking-wider text-white">FARREL<span class="text-accentRed">.</span></a>
            <h2 class="text-xl font-bold text-white mt-4">Verifikasi Kode OTP</h2>
            <p class="text-xs text-gray-400 mt-2">Kami telah mengirim 6 digit kode ke email <strong class="text-white">{{ session('reset_email') }}</strong>. Kode berlaku selama 10 menit.</p>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-xs text-center font-medium">
            {{ $errors->first() }}
        </div>
        @endif

        @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 text-xs text-center font-medium">
            {{ session('success') }}
        </div>
        @endif

        @if(!empty($devOtp))
        <div class="mb-6 p-4 bg-yellow-500/10 border border-yellow-500/40 rounded-xl text-yellow-300 text-xs text-center space-y-1">
            <p class="font-bold flex items-center justify-center space-x-2">
                <i class="fa-solid fa-flask"></i>
                <span>Mode Development (SMTP belum aktif)</span>
            </p>
            <p class="text-[10px] text-yellow-200/80">Kode OTP Anda (untuk testing):</p>
            <p class="font-mono text-2xl font-black text-white tracking-[8px] mt-2 select-all">{{ $devOtp }}</p>
            <p class="text-[10px] text-yellow-200/60 mt-2">Aktifkan SMTP di menu <strong>Admin → SMTP</strong> agar email benar-benar terkirim ke Gmail.</p>
        </div>
        @endif

        <form action="{{ route('admin.forgot.password.verify') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Kode OTP 6 Digit</label>
                <input type="text" name="otp" maxlength="6" pattern="[0-9]{6}" required autofocus
                    placeholder="000000"
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important; letter-spacing: 12px; text-align: center; font-size: 1.5rem;"
                    class="w-full rounded-xl px-4 py-4 focus:outline-none focus:border-accentRed transition font-mono font-bold">
            </div>

            <button type="submit" class="w-full bg-accentRed hover:bg-accentRedHover text-white py-3.5 rounded-xl font-bold shadow-lg shadow-accentRed/30 transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Verifikasi Kode</span>
            </button>
        </form>

        <div class="mt-6 text-center space-y-2">
            <form action="{{ route('admin.forgot.password.send') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                <button type="submit" class="text-xs text-gray-400 hover:text-accentRed transition">
                    <i class="fa-solid fa-rotate-right"></i> Kirim Ulang Kode
                </button>
            </form>
            <a href="{{ route('admin.forgot.password') }}" class="block text-xs text-gray-400 hover:text-accentRed transition">← Ganti Email</a>
        </div>
    </div>

    <script>
        // Auto-format OTP input to digits only
        document.querySelector('input[name="otp"]')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    </script>

</body>
</html>
