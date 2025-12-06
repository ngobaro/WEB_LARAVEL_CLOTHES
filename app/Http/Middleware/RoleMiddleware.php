<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Middleware kiểm tra quyền truy cập dựa trên vai trò người dùng.
     *
     * Mô tả:
     * - Middleware này sẽ kiểm tra xem người dùng đã đăng nhập hay chưa
     *   và có vai trò cụ thể mà bạn cung cấp qua tham số `$role` hay không. 
     *   Nếu không có quyền, sẽ trả về lỗi 403 (Forbidden).
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập và có vai trò được chỉ định hay không
        if (!auth()->check() || !auth()->user()->hasRole($role)) {
            // Nếu không có quyền, trả về lỗi 403 với thông điệp
            abort(403, 'Bạn không có quyền truy cập!');
        }

        // Nếu có quyền, tiếp tục yêu cầu
        return $next($request);
    }
}