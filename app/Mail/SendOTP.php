<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOTP extends Mailable
{
    use Queueable, SerializesModels;

    // Biến chứa thông tin người dùng
    public $user;
    
    // Biến chứa mã OTP
    public $otp;

    /**
     * Khởi tạo lớp SendOTP.
     *
     * Mô tả:
     * - Nhận thông tin người dùng và mã OTP để sử dụng trong email.
     *
     * @param User $user
     * @param string $otp
     */
    public function __construct(User $user, $otp)
    {
        $this->user = $user;  // Gán thông tin người dùng
        $this->otp = $otp;    // Gán mã OTP
    }

    /**
     * Thiết lập nội dung email.
     *
     * Mô tả:
     * - Đặt tiêu đề cho email và chỉ định view hiển thị nội dung.
     * - Truyền thông tin người dùng và mã OTP đến view.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Mã OTP Xác Thực - Clothes Store')  // Tiêu đề email
                    ->view('emails.otp')  // View emails/otp.blade.php
                    ->with(['user' => $this->user, 'otp' => $this->otp]);  // Truyền dữ liệu tới view
    }
}