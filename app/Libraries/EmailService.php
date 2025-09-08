<?php

namespace App\Libraries;

use CodeIgniter\Email\Email;

class EmailService {
    protected $email;
    
    public function __construct() {
        $this->email = \Config\Services::email();
    }
    
    /**
     * Kirim email OTP
     * 
     * @param string $recipientEmail
     * @param string $otpCode
     * @param string $type
     * @return bool
     */
    public function sendOTP(string $recipientEmail, string $otpCode, string $type): bool
    {
        $subject = ($type === 'register') ? 'Verifikasi Akun Anda' : 'Reset Password';
        $message = $this->getOtpEmailTemplate($recipientEmail, $otpCode, $type);
        
        $this->email->setFrom('noreply@promedico.com', 'Klinik Gigi Promedico');
        $this->email->setTo($recipientEmail);
        $this->email->setSubject($subject);
        $this->email->setMessage($message);
        
        return $this->email->send();
    }
    
    /**
     * Get HTML template untuk email OTP
     * 
     * @param string $email
     * @param string $otpCode
     * @param string $type
     * @return string
     */
    private function getOtpEmailTemplate(string $email, string $otpCode, string $type): string
    {
        $title = ($type === 'register') ? 'Verifikasi Akun Anda' : 'Reset Password';
        $message = ($type === 'register') 
            ? 'Terima kasih telah mendaftar. Gunakan kode OTP berikut untuk menyelesaikan proses pendaftaran.'
            : 'Kami menerima permintaan untuk reset password akun Anda. Gunakan kode OTP berikut untuk melanjutkan.';

        $template = '
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $title . '</title>
    <style>
        body {
            font-family: "Plus Jakarta Sans", Arial, sans-serif;
            line-height: 1.6;
            color: #1f2937;
            background: linear-gradient(135deg, #f0f7f7 0%, #e6fffa 100%);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #0d9488, #14b8a6, #2dd4bf);
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        .header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.1"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") repeat;
        }
        .logo {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        .logo-icon {
            display: inline-block;
            margin-right: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }
        .content {
            padding: 40px 30px;
        }
        .welcome-text {
            font-size: 18px;
            color: #0d9488;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .message-text {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        .otp-container {
            background: linear-gradient(135deg, #f0fdfa, #ecfdf5);
            border: 2px solid #a7f3d0;
            border-radius: 16px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .otp-container::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(20, 184, 166, 0.1), transparent);
            animation: shimmer 3s infinite;
        }
        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }
        .otp-label {
            font-size: 14px;
            color: #059669;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .otp-code {
            font-size: 36px;
            font-weight: 800;
            text-align: center;
            letter-spacing: 8px;
            color: #0d9488;
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 2px dashed #14b8a6;
            margin: 0;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .otp-info {
            font-size: 14px;
            color: #6b7280;
            margin-top: 20px;
            font-style: italic;
        }
        .warning-text {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 12px;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
            color: #92400e;
        }
        .footer {
            background: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer-text {
            font-size: 12px;
            color: #6b7280;
            margin: 5px 0;
        }
        .footer-brand {
            font-size: 14px;
            color: #0d9488;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-link {
            display: inline-block;
            margin: 0 10px;
            color: #14b8a6;
            text-decoration: none;
            font-size: 16px;
        }
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #d1d5db, transparent);
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <span class="logo-icon">🦷</span>
                Promedico
            </div>
            <h2>' . $title . '</h2>
        </div>
        <div class="content">
            <div class="welcome-text">Halo!</div>
            <div class="message-text">' . $message . '</div>
            
            <div class="otp-container">
                <div class="otp-label">Kode Verifikasi Anda</div>
                <div class="otp-code">' . $otpCode . '</div>
                <div class="otp-info">Kode ini berlaku selama 10 menit</div>
            </div>
            
            <div class="warning-text">
                ⚠️ <strong>Penting:</strong> Jangan berikan kode ini kepada siapapun, termasuk tim Promedico. Kami tidak akan pernah meminta kode verifikasi Anda.
            </div>
            
            <p style="color: #6b7280; font-size: 14px;">
                Jika Anda tidak melakukan permintaan ini, harap abaikan email ini dan pastikan akun Anda aman.
            </p>
            
            <div class="divider"></div>
            
            <p style="color: #0d9488; font-weight: 600;">
                Terima kasih telah mempercayai Promedico!<br>
                <span style="font-size: 14px; color: #6b7280;">Tim Klinik Gigi Promedico</span>
            </p>
        </div>
        <div class="footer">
            <div class="footer-brand">Klinik Gigi Promedico</div>
            <div class="footer-text">Seni & Sains dalam Senyuman Sempurna</div>
            <div class="social-links">
                <a href="#" class="social-link">📧</a>
                <a href="#" class="social-link">📱</a>
                <a href="#" class="social-link">🌐</a>
            </div>
            <div class="footer-text">Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</div>
            <div class="footer-text">&copy; ' . date('Y') . ' Promedico. All rights reserved.</div>
        </div>
    </div>
</body>
</html>';

        return $template;
    }
} 