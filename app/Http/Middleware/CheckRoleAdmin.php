<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleAdmin
{
    /**
     * Middleware kiểm tra quyền truy cập của người dùng.
     *
     * Mô tả:
     * - Middleware này sẽ được sử dụng để kiểm tra xem người dùng đã đăng nhập chưa
     *   và có phải là admin hay không. Nếu không, sẽ trả về lỗi 403 (Forbidden).
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập và có quyền admin chưa
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {  // Dùng hasRole từ User model
            // Nếu không có quyền, trả về lỗi 403 với thông điệp
            abort(403, 'Bạn không có quyền truy cập trang này!');
        }

        // Nếu có quyền, tiếp tục yêu cầu
        return $next($request);
    }
}