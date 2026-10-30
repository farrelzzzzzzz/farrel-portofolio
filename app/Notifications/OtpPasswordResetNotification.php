<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpPasswordResetNotification extends Notification
{
    use Queueable;

    public function __construct(public string $otp) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Kode OTP Reset Sandi — Farrel Admin')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Kami menerima permintaan untuk mereset kata sandi akun admin portofolio Anda.')
            ->line('Gunakan kode OTP 6 digit di bawah ini untuk melanjutkan proses reset:')
            ->line('')
            ->line('## KODE OTP: ' . $this->otp)
            ->line('')
            ->line('Kode ini **berlaku selama 10 menit** dan hanya dapat digunakan satu kali.')
            ->line('Jika Anda tidak merasa meminta reset kata sandi, abaikan email ini atau abaikan pesan ini.')
            ->salutation('Salam, ' . config('app.name', 'Farrel Admin'));
    }
}
