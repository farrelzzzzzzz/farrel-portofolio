<?php

use App\Models\Project;
use App\Models\Certificate;
use App\Models\Magazine;
use App\Models\Setting;
use App\Models\User;
use App\Http\Controllers\MagazineController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\AssetController;
use App\Notifications\OtpPasswordResetNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Http;

require __DIR__.'/umkm.php';
require __DIR__.'/locale.php';

/*
|--------------------------------------------------------------------------
| PUBLIC WEB (Front-end / "Web Utama")
|--------------------------------------------------------------------------
| All of these pull from the same SQLite database that the admin writes to.
*/

Route::get('/', [AssetController::class, 'index'])->name('portfolio.index');

Route::get('/assets/{type?}', [AssetController::class, 'index'])
    ->where('type', '3d|image|video|figma|magazine|certificate|all')
    ->name('portfolio.assets');

// Backwards-compatible: /project/{slug} still works for project detail pages
Route::get('/project/{slug}', function ($slug) {
    $project = Project::where('slug', $slug)->firstOrFail();
    $project->increment('views');
    return view('project-detail', compact('project'));
})->name('project.show');

Route::get('/certificates', function () {
    $certificates = Certificate::latest()->get();
    return view('certificates', compact('certificates'));
})->name('certificates');

/*
|--------------------------------------------------------------------------
| MAGAZINE (DO NOT TOUCH — fixes IDM / HTTP 204 issue for PDF streaming)
|--------------------------------------------------------------------------
*/
Route::get('/magazine/{magazine}', [MagazineController::class, 'show'])->name('magazine.show');

Route::get('/magazine/{magazine}/pdf', [MagazineController::class, 'stream'])
    ->withoutMiddleware([
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
    ])
    ->name('magazine.pdf');

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', function () {
    $recovery = [
        'whatsapp'      => \App\Models\Setting::get('admin_whatsapp', '6289666882598'),
        'whatsapp_label'=> \App\Models\Setting::get('admin_whatsapp_label', '089666882598'),
        'email'         => \App\Models\Setting::get('admin_email', 'admin@farrel.com'),
    ];
    return view('admin.login', compact('recovery'));
})->name('login');

/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD FLOW (OTP via Email)
|--------------------------------------------------------------------------
*/
Route::get('/admin/forgot-password', function () {
    return view('admin.forgot-password');
})->name('admin.forgot.password');

Route::post('/admin/forgot-password', function (Request $request) {
    $data = $request->validate(['email' => ['required', 'email']]);
    $user = User::where('email', $data['email'])->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email tidak terdaftar sebagai admin.'])->withInput();
    }

    // Generate 6-digit OTP
    $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $user->otp_code = $otp;
    $user->otp_expires_at = now()->addMinutes(10);
    $user->save();

    // Send OTP via email notification
    try {
        Notification::send($user, new OtpPasswordResetNotification($otp));
    } catch (\Throwable $e) {
        \Log::error('OTP email send failed: ' . $e->getMessage());
    }

    // Persist OTP & email in session explicitly via the request lifecycle
    $request->session()->put('reset_email', $user->email);
    $request->session()->put('reset_otp', $otp);
    $request->session()->save();

    return redirect()->route('admin.forgot.password.verify')
        ->with('success', 'Kode OTP telah dikirim ke email ' . $user->email . '. Silakan cek inbox atau folder spam.');
})->name('admin.forgot.password.send');

Route::get('/admin/verify-otp', function (Request $request) {
    if (!$request->session()->has('reset_email')) {
        return redirect()->route('admin.forgot.password');
    }
    // In development (log mailer), expose the latest OTP for the user
    $devOtp = null;
    if (env('MAIL_MAILER', 'log') === 'log') {
        $user = \App\Models\User::where('email', $request->session()->get('reset_email'))->first();
        if ($user && $user->otp_code && $user->otp_expires_at && $user->otp_expires_at->isFuture()) {
            $devOtp = $user->otp_code;
        }
    }
    return view('admin.verify-otp', compact('devOtp'));
})->name('admin.forgot.password.verify');

Route::post('/admin/verify-otp', function (Request $request) {
    $data = $request->validate(['otp' => ['required', 'string', 'size:6']]);
    $email = $request->session()->get('reset_email');

    if (!$email) {
        return redirect()->route('admin.forgot.password')->withErrors(['email' => 'Sesi habis, silakan ulangi.']);
    }

    $user = User::where('email', $email)->first();

    if (!$user || !$user->otp_code || $user->otp_code !== $data['otp']) {
        return back()->withErrors(['otp' => 'Kode OTP salah.'])->withInput();
    }

    if ($user->otp_expires_at && $user->otp_expires_at->isPast()) {
        return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang.']);
    }

    return redirect()->route('admin.forgot.password.reset');
})->name('admin.forgot.password.verify');

Route::get('/admin/reset-password', function (Request $request) {
    if (!$request->session()->has('reset_email')) {
        return redirect()->route('admin.forgot.password');
    }
    return view('admin.reset-password');
})->name('admin.forgot.password.reset');

Route::post('/admin/reset-password', function (Request $request) {
    $data = $request->validate([
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $email = $request->session()->get('reset_email');
    if (!$email) {
        return redirect()->route('admin.forgot.password');
    }

    $user = User::where('email', $email)->first();
    if (!$user) {
        return redirect()->route('admin.forgot.password');
    }

    $user->password = Hash::make($data['password']);
    $user->otp_code = null;
    $user->otp_expires_at = null;
    $user->save();

    // Clear session flags
    $request->session()->forget('reset_email');
    $request->session()->forget('reset_otp');
    $request->session()->save();

    return redirect()->route('login')->with('success', 'Sandi berhasil diperbarui. Silakan login dengan sandi baru Anda.');
})->name('admin.forgot.password.reset');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/admin/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

/*
|--------------------------------------------------------------------------
| ADMIN (CRUD) — Single source of truth for portfolio data
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ----- Dashboard -----
    Route::get('/admin/dashboard', function () {
        $projects     = Project::latest()->get();
        $certificates = Certificate::latest()->get();
        $magazines    = Magazine::latest()->get();

        // Stats are computed from DB; no hard-coded numbers.
        $stats = [
            'total'       => $projects->count() + $certificates->count() + $magazines->count(),
            '3d'          => $projects->where('category', '3D Design')->count(),
            'image'       => $projects->where('category', 'Graphic Design')->count(),
            'video'       => $projects->where('category', 'Animation')->count(),
            'figma'       => $projects->where('category', 'UI/UX Design')->count(),
            'magazine'    => $magazines->count(),
            'certificate' => $certificates->count(),
        ];

        return view('admin.dashboard', compact(
            'projects', 'certificates', 'magazines', 'stats'
        ));
    })->name('admin.dashboard');

    // ----- Projects (3D / Image / Video / Figma) -----
    Route::post('/admin/projects',                  [ProjectController::class, 'store'])->name('admin.projects.store');
    Route::get('/admin/projects/{project}/edit',    [ProjectController::class, 'edit'])->name('admin.projects.edit');
    Route::put('/admin/projects/{project}',         [ProjectController::class, 'update'])->name('admin.projects.update');
    Route::delete('/admin/projects/{project}',      [ProjectController::class, 'destroy'])->name('admin.projects.destroy');

    // ----- Certificates -----
    Route::post('/admin/certificates',                  [CertificateController::class, 'store'])->name('admin.certificates.store');
    Route::get('/admin/certificates/{certificate}/edit',  [CertificateController::class, 'edit'])->name('admin.certificates.edit');
    Route::put('/admin/certificates/{certificate}',     [CertificateController::class, 'update'])->name('admin.certificates.update');
    Route::delete('/admin/certificates/{certificate}',  [CertificateController::class, 'destroy'])->name('admin.certificates.destroy');

    // ----- Magazines -----
    Route::get('/admin/magazines',                  [MagazineController::class, 'index'])->name('admin.magazines.index');
    Route::get('/admin/magazines/create',           [MagazineController::class, 'create'])->name('admin.magazines.create');
    Route::post('/admin/magazines',                 [MagazineController::class, 'store'])->name('admin.magazines.store');
    Route::get('/admin/magazines/{magazine}/edit',  [MagazineController::class, 'edit'])->name('admin.magazines.edit');
    Route::put('/admin/magazines/{magazine}',       [MagazineController::class, 'update'])->name('admin.magazines.update');
    Route::delete('/admin/magazines/{magazine}',    [MagazineController::class, 'destroy'])->name('admin.magazines.destroy');

    // ----- Logout -----
    Route::post('/admin/logout', function (Request $request) {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    })->name('admin.logout');

    // ----- Settings (Dynamic contact info for forgot password) -----
    Route::get('/admin/settings', function () {
        $settings = [
            'admin_whatsapp'   => Setting::get('admin_whatsapp', '6289666882598'),
            'admin_email'      => Setting::get('admin_email', 'admin@farrel.com'),
            'admin_whatsapp_label' => Setting::get('admin_whatsapp_label', '0896666882598'),
            'fonnte_token'     => Setting::get('fonnte_token', ''),
        ];
        return view('admin.settings', compact('settings'));
    })->name('admin.settings');

    // ----- SMTP Setup (Gmail) -----
    Route::get('/admin/smtp-setup', function () {
        $config = [
            'mail_mailer'     => env('MAIL_MAILER', 'log'),
            'mail_host'       => env('MAIL_HOST', 'smtp.gmail.com'),
            'mail_port'       => env('MAIL_PORT', 587),
            'mail_username'   => env('MAIL_USERNAME', ''),
            'mail_password'   => env('MAIL_PASSWORD', ''),
            'mail_from_name'  => env('MAIL_FROM_NAME', 'Farrel Admin'),
        ];
        return view('admin.smtp-setup', compact('config'));
    })->name('admin.smtp.setup');

    Route::post('/admin/smtp-setup', function (Request $request) {
        $data = $request->validate([
            'mail_username'   => ['required', 'email'],
            'mail_password'   => ['required', 'string', 'min:8'],
            'mail_from_name'  => ['required', 'string', 'max:255'],
        ]);

        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return back()->withErrors(['mail_username' => 'File .env tidak ditemukan di project.']);
        }

        $envContent = file_get_contents($envPath);

        // Force update MAIL_MAILER to smtp
        $envContent = preg_replace('/^MAIL_MAILER=.*$/m', 'MAIL_MAILER=smtp', $envContent);
        // Ensure MAIL_HOST is smtp.gmail.com
        $envContent = preg_replace('/^MAIL_HOST=.*$/m', 'MAIL_HOST=smtp.gmail.com', $envContent);
        $envContent = preg_replace('/^MAIL_PORT=.*$/m', 'MAIL_PORT=587', $envContent);
        $envContent = preg_replace('/^MAIL_ENCRYPTION=.*$/m', 'MAIL_ENCRYPTION=tls', $envContent);
        $envContent = preg_replace('/^MAIL_SCHEME=.*$/m', 'MAIL_SCHEME=null', $envContent);

        // Update username
        if (preg_match('/^MAIL_USERNAME=.*$/m', $envContent)) {
            $envContent = preg_replace('/^MAIL_USERNAME=.*$/m', 'MAIL_USERNAME=' . $data['mail_username'], $envContent);
        } else {
            $envContent .= "\nMAIL_USERNAME=" . $data['mail_username'];
        }

        // Update password (remove spaces from app password)
        $cleanPassword = str_replace(' ', '', $data['mail_password']);
        if (preg_match('/^MAIL_PASSWORD=.*$/m', $envContent)) {
            $envContent = preg_replace('/^MAIL_PASSWORD=.*$/m', 'MAIL_PASSWORD=' . $cleanPassword, $envContent);
        } else {
            $envContent .= "\nMAIL_PASSWORD=" . $cleanPassword;
        }

        // Update from address = username
        if (preg_match('/^MAIL_FROM_ADDRESS=.*$/m', $envContent)) {
            $envContent = preg_replace('/^MAIL_FROM_ADDRESS=.*$/m', 'MAIL_FROM_ADDRESS="' . $data['mail_username'] . '"', $envContent);
        } else {
            $envContent .= "\nMAIL_FROM_ADDRESS=\"" . $data['mail_username'] . "\"";
        }

        // Update from name
        if (preg_match('/^MAIL_FROM_NAME=.*$/m', $envContent)) {
            $envContent = preg_replace('/^MAIL_FROM_NAME=.*$/m', 'MAIL_FROM_NAME="' . $data['mail_from_name'] . '"', $envContent);
        } else {
            $envContent .= "\nMAIL_FROM_NAME=\"" . $data['mail_from_name'] . "\"";
        }

        file_put_contents($envPath, $envContent);

        // Clear config cache to apply changes
        \Illuminate\Support\Facades\Artisan::call('config:clear');

        return redirect()->route('admin.smtp.setup')->with('success', 'Konfigurasi SMTP Gmail berhasil disimpan! Sekarang email OTP akan benar-benar terkirim ke Gmail.');
    })->name('admin.smtp.update');

    Route::post('/admin/settings', function (Request $request) {
        $data = $request->validate([
            'admin_whatsapp'        => ['required', 'string', 'max:30'],
            'admin_whatsapp_label'  => ['required', 'string', 'max:30'],
            'admin_email'           => ['required', 'email', 'max:255'],
            'fonnte_token'          => ['nullable', 'string', 'max:255'],
        ]);
        // Sanitize whatsapp number to digits only (international format, e.g. 6289...)
        $digits = preg_replace('/[^0-9]/', '', $data['admin_whatsapp']);
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }
        Setting::set('admin_whatsapp', $digits, 'WhatsApp Number (Intl)', 'text');
        Setting::set('admin_whatsapp_label', $data['admin_whatsapp_label'], 'WhatsApp Display Label', 'text');
        Setting::set('admin_email', $data['admin_email'], 'Recovery Email', 'email');
        Setting::set('fonnte_token', $data['fonnte_token'] ?? '', 'Fonnte API Token (WhatsApp Gateway)', 'text');
        return redirect()->route('admin.settings')->with('success', 'Kontak pemulihan & konfigurasi WhatsApp berhasil diperbarui.');
    })->name('admin.settings.update');

    // ----- Update Admin Login Credentials (Email & Password) -----
    Route::put('/admin/settings/credentials', function (Request $request) {
        $user = auth()->user();
        $rules = [
            'login_email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ];
        $messages = [
            'login_email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ];

        // If new password is provided, validate it & require current password confirmation
        if ($request->filled('new_password')) {
            $rules['current_password'] = ['required', 'string'];
            $rules['new_password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $data = $request->validate($rules, $messages);

        // If changing password, verify the current one first
        if ($request->filled('new_password')) {
            if (!\Hash::check($data['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }
            $user->password = \Hash::make($data['new_password']);
        }

        $user->email = $data['login_email'];
        $user->save();

        return redirect()->route('admin.settings')->with('success', 'Akun login (email & password) berhasil diperbarui.');
    })->name('admin.credentials.update');
});

// Public endpoint to expose contact info (used by login page)
Route::get('/admin/recovery-contacts', function () {
    return response()->json([
        'whatsapp'      => Setting::get('admin_whatsapp', '6289666882598'),
        'whatsapp_label'=> Setting::get('admin_whatsapp_label', '0896666882598'),
        'email'         => Setting::get('admin_email', 'admin@farrel.com'),
    ]);
})->name('admin.recovery.contacts');

/*
|--------------------------------------------------------------------------
| RESET PASSWORD VIA WHATSAPP
|--------------------------------------------------------------------------
*/
Route::get('/admin/reset-via-wa', function () {
    $recovery = [
        'whatsapp'      => Setting::get('admin_whatsapp', '6289666882598'),
        'whatsapp_label'=> Setting::get('admin_whatsapp_label', '0896666882598'),
    ];
    return view('admin.reset-via-wa', compact('recovery'));
})->name('admin.wa.reset');

Route::post('/admin/reset-via-wa', function (Request $request) {
    $data = $request->validate(['email' => ['required', 'email']]);
    $user = User::where('email', $data['email'])->first();

    if (!$user) {
        return back()->withErrors(['email' => 'Email tidak terdaftar sebagai admin.'])->withInput();
    }

    // Generate 6-digit OTP
    $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    $user->otp_code = $otp;
    $user->otp_expires_at = now()->addMinutes(10);
    $user->save();

    // Try to send via Fonnte WhatsApp Gateway (if configured)
    $waSent = false;
    $waNumber = Setting::get('admin_whatsapp', '6289666882598');
    $fonnteToken = Setting::get('fonnte_token', '');

    if (!empty($fonnteToken)) {
        try {
            $response = Http::withHeaders([
                'Authorization' => $fonnteToken,
            ])->post('https://api.fonnte.com/send', [
                'target' => $waNumber,
                'message' => "🔐 *Kode OTP Reset Sandi*\n\nKode OTP Anda: *{$otp}*\n\nKode berlaku selama 10 menit. Jangan berikan kode ini kepada siapa pun.\n\n— Farrel Admin",
            ]);
            $waSent = $response->successful();
        } catch (\Throwable $e) {
            \Log::error('Fonnte WA send failed: ' . $e->getMessage());
        }
    }

    $request->session()->put('reset_email', $user->email);
    $request->session()->put('reset_otp', $otp);
    $request->session()->save();

    return redirect()->route('admin.wa.reset.verify')
        ->with('success', $waSent
            ? 'Kode OTP telah dikirim ke WhatsApp admin. Silakan cek WhatsApp Anda.'
            : 'Kode OTP telah dibuat. (Mode development — lihat di bawah untuk kodenya)');
})->name('admin.wa.reset.send');

Route::get('/admin/verify-wa-otp', function (Request $request) {
    if (!$request->session()->has('reset_email')) {
        return redirect()->route('admin.wa.reset');
    }
    $recovery = [
        'whatsapp_label' => Setting::get('admin_whatsapp_label', '0896666882598'),
    ];
    $devOtp = null;
    $fonnteToken = Setting::get('fonnte_token', '');
    if (empty($fonnteToken)) {
        $user = \App\Models\User::where('email', $request->session()->get('reset_email'))->first();
        if ($user && $user->otp_code && $user->otp_expires_at && $user->otp_expires_at->isFuture()) {
            $devOtp = $user->otp_code;
        }
    }
    return view('admin.verify-wa-otp', compact('recovery', 'devOtp'));
})->name('admin.wa.reset.verify');

Route::post('/admin/verify-wa-otp', function (Request $request) {
    $data = $request->validate(['otp' => ['required', 'string', 'size:6']]);
    $email = $request->session()->get('reset_email');

    if (!$email) {
        return redirect()->route('admin.wa.reset')->withErrors(['email' => 'Sesi habis, silakan ulangi.']);
    }

    $user = User::where('email', $email)->first();
    if (!$user || !$user->otp_code || $user->otp_code !== $data['otp']) {
        return back()->withErrors(['otp' => 'Kode OTP salah.'])->withInput();
    }
    if ($user->otp_expires_at && $user->otp_expires_at->isPast()) {
        return back()->withErrors(['otp' => 'Kode OTP sudah kadaluarsa. Silakan kirim ulang.']);
    }

    return redirect()->route('admin.forgot.password.reset');
})->name('admin.wa.reset.verify');
