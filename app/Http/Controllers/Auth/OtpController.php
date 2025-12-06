<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;

class OtpController extends Controller
{
    /**
     * Hiển thị form đăng nhập (email + password).
     *
     * @return \Illuminate\View\View
     */
    public function showForm()
    {
        return view('auth.login');  // Trả về view đăng nhập
    }

    /**
     * Đăng nhập bằng email và mật khẩu (không sử dụng OTP).
     *
     * Mô tả:
     * - Xác thực dữ liệu đầu vào.
     * - Nếu thành công, kiểm tra vai trò người dùng và chuyển hướng đến trang tương ứng.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
   
    // Đăng nhập chuẩn (email + password, không OTP)
    public function loginStandard(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->hasRole('admin')) {
                return redirect('/admin/dashboard');  // Admin nhảy dashboard
            }

            return redirect()->intended('/');  // User thường về trang chủ
        }

        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ])->onlyInput('email');
    }

    /**
     * Hiển thị form xác thực OTP (chung cho login và register).
     *
     * Mô tả:
     * - Kiểm tra xem người dùng đã đăng nhập hay chưa thông qua session.
     * - Xác định loại xác thực (đăng nhập hoặc đăng ký).
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showVerifyForm(Request $request)
    {
        $email = session('email') ?? session('register_email');  // Lấy email từ session
        if (!$email) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập trước!');  // Nếu không có email, redirect về đăng nhập
        }

        $type = session('otp_type', 'login'); // Xác định loại xác thực (mặc định là 'login')

        return view('auth.verify', compact('email', 'type'));  // Trả về view xác thực OTP với email và loại
    }

    /**
     * Xác thực mã OTP.
     *
     * Mô tả:
     * - Xác thực dữ liệu đầu vào và kiểm tra mã OTP của người dùng.
     * - Nếu OTP hợp lệ, đăng nhập người dùng và xóa session liên quan.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyOtp(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'email' => 'required|email',  // Email bắt buộc và hợp lệ
            'otp' => 'required|digits:6',  // Mã OTP phải là 6 chữ số
        ]);

        // Tìm người dùng theo email
        $user = User::where('email', $request->email)->first();  

        if (!$user) {
            return back()->with('error', 'Email không tồn tại!');  // Nếu không tìm thấy người dùng
        }

        // Kiểm tra mã OTP
        if ($user->verifyOtp($request->otp)) {
            $user->otp_code = null;  // Xóa mã OTP
            $user->otp_expires = null;  // Xóa thời gian hết hạn
            $user->save();  // Lưu thay đổi vào cơ sở dữ liệu

            Auth::login($user);  // Đăng nhập người dùng

            // Xóa session liên quan
            $request->session()->forget(['email', 'register_email', 'otp_type']);

            return redirect('/')->with('success', 'Đăng nhập thành công!');  // Chuyển hướng về trang chủ với thông báo thành công
        }

        return back()->with('error', 'OTP sai hoặc hết hạn!');  // Nếu OTP không hợp lệ
    }

    /**
     * Đăng xuất người dùng.
     *
     * Mô tả:
     * - Đăng xuất người dùng và xóa session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();  // Đăng xuất người dùng
        $request->session()->invalidate();  // Xóa session
        $request->session()->regenerateToken();  // Tạo lại CSRF token để bảo mật

        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');  // Chuyển hướng về trang đăng nhập
    }
}