<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;

class RegisterController extends Controller
{
    /**
     * Hiển thị form đăng ký.
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        return view('auth.register');  // Trả về view đăng ký
    }

    /**
     * Xử lý yêu cầu đăng ký người dùng.
     *
     * Mô tả:
     * - Xác thực dữ liệu đầu vào từ request.
     * - Tạo người dùng mới và gửi mã OTP qua email.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',  // Tên bắt buộc, tối đa 255 ký tự
            'email' => 'required|string|email|max:255|unique:users',  // Email duy nhất, hợp lệ
            'password' => 'required|string|min:8|confirmed',  // Mật khẩu bắt buộc, tối thiểu 8 ký tự và phải khớp
        ]);

        // Tạo mới người dùng
        $user = User::create([
            'name' => $request->name,  // Tên người dùng
            'email' => $request->email,  // Địa chỉ email của người dùng
            'password' => Hash::make($request->password),  // Mã hóa mật khẩu
            'role' => 'customer',  // Gán vai trò mặc định cho người dùng
        ]);

        // Tạo mã OTP ngẫu nhiên cho đăng ký
        $otp = rand(100000, 999999);
        $user->otp_code = $otp;  // Gán mã OTP cho người dùng
        $user->otp_expires = now()->addMinutes(5);  // Đặt thời gian hết hạn cho mã OTP
        $user->save();  // Lưu thay đổi vào cơ sở dữ liệu

        // Ghi log OTP (xóa sau nếu không cần thiết)
        // \Log::info("OTP lưu cho user {$user->id}: $otp, hết hạn: " . $user->otp_expires);

        session(['email' => $request->email]);  // Lưu email vào phiên để sử dụng sau

        // Gửi mã OTP qua email
        Mail::to($user->email)->send(new SendOTP($user, $otp));

        // Chuyển hướng tới trang xác thực OTP với thông báo thành công
        return redirect()->route('otp.verify.form')->with('message', 'Đăng ký thành công! Kiểm tra email để lấy mã OTP.');
    }
}