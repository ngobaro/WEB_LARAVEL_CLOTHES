<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;  // Import Mailable SendOTP (nếu có, nếu chưa tạo thì dùng raw dưới)

class OtpController extends Controller
{
    // Form đăng nhập (email + pass)
    public function showForm()
    {
        return view('auth.login');
    }

    // Attempt login (validate email/pass, nếu đúng thì gửi OTP)
    public function loginAttempt(LoginRequest $request)
    {
       
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->with('error', 'Email hoặc mật khẩu sai!');
        }

        $user = Auth::user();  // Login tạm thành công

        $otp = rand(100000, 999999);
        $user->otp_code = $otp;
        $user->otp_expires = now()->addMinutes(5);
        $user->save();

        session(['email' => $request->email]);

        // Gửi mail OTP (dùng Mailable SendOTP nếu có, hoặc raw)
        Mail::to($user->email)->send(new SendOTP($user, $otp));  // Nếu có Mailable
        // Hoặc raw nếu chưa tạo Mailable:
        // Mail::raw("Mã OTP của bạn là: {$otp}. Hết hạn sau 5 phút.", function ($message) use ($user) {
        //     $message->to($user->email)->subject('Mã OTP Xác Thực - Clothes Store');
        // });

        return redirect()->route('otp.verify.form')->with('message', 'Mật khẩu đúng! Kiểm tra email để lấy mã OTP.');
    }

    // Hiển thị form verify OTP
    public function showVerifyForm()
    {
        $email = session('email');
        if (!$email) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập trước!');
        }

        return view('auth.verify', compact('email'));
    }

    // Verify OTP (kiểm tra mã, login nếu đúng)
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email không tồn tại!');
        }

        if ($user->verifyOtp($request->otp)) {
            Auth::login($user);  // Login thật
            $user->otp_code = null;
            $user->otp_expires = null;
            $user->save();

            //cái này nếu thành công trỏ tới view/admin/dashboard
            return redirect('/admin/dashboard')->with('success', 'Đăng nhập thành công!');
        }

        return back()->with('error', 'OTP sai hoặc hết hạn!');
    }
     public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Đăng xuất thành công!');
    }
    
}