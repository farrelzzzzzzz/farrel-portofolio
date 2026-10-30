<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP WhatsApp — Farrel Admin</title>
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
            <h2 class="text-xl font-bold text-white mt-4">Verifikasi OTP WhatsApp</h2>
            <p class="text-xs text-gray-400 mt-2">Kami telah mengirim 6 digit kode ke WhatsApp <strong class="text-emerald-400">{{ $recovery['whatsapp_label'] }}</strong>. Kode berlaku selama 10 menit.</p>
        </div>

        @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 rounded-xl text-red-500 text-xs text-center font-medium">
            {{ $errors->first() }}
        </div>
        @endif

        @if(!empty($devOtp))
        <div class="mb-6 p-4 bg-yellow-500/10 border border-yellow-500/40 rounded-xl text-yellow-300 text-xs text-center space-y-1">
            <p class="font-bold flex items-center justify-center space-x-2">
                <i class="fa-solid fa-flask"></i>
                <span>Mode Development</span>
            </p>
            <p class="text-[10px] text-yellow-200/80">Kode OTP Anda:</p>
            <p class="font-mono text-2xl font-black text-white tracking-[8px] mt-2 select-all">{{ $devOtp }}</p>
        </div>
        @endif

        <form action="{{ route('admin.wa.reset.verify') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Kode OTP 6 Digit</label>
                <input type="text" name="otp" maxlength="6" pattern="[0-9]{6}" required autofocus
                    placeholder="000000"
                    style="background-color: #0b0b0f !important; color: #ffffff !important; border: 1px solid #232330 !important; letter-spacing: 12px; text-align: center; font-size: 1.5rem;"
                    class="w-full rounded-xl px-4 py-4 focus:outline-none focus:border-emerald-500 transition font-mono font-bold">
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-emerald-600/30 transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Verifikasi Kode</span>
            </button>
        </form>

        <div class="mt-6 text-center space-y-2">
            <form action="{{ route('admin.wa.reset.send') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                <button type="submit" class="text-xs text-gray-400 hover:text-emerald-400 transition">
                    <i class="fa-solid fa-rotate-right"></i> Kirim Ulang Kode
                </button>
            </form>
            <a href="{{ route('admin.wa.reset') }}" class="block text-xs text-gray-400 hover:text-accentRed transition">← Ganti Email</a>
        </div>
    </div>

    <script>
        document.querySelector('input[name="otp"]')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    </script>

</body>
</html>
