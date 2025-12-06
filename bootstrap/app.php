<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRoleAdmin;  // Import middleware kiểm tra quyền admin
use Illuminate\Support\Facades\Route;

// Cấu hình ứng dụng
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',  // Đường dẫn tới file route cho web
        commands: __DIR__.'/../routes/console.php',  // Đường dẫn tới file route cho console commands
        health: '/up',  // Endpoint để kiểm tra tình trạng của ứng dụng
        then: function () {
            // Nhóm các route cho admin với middleware 'web'
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Đặt alias cho middleware
        $middleware->alias([
            'admin' => CheckRoleAdmin::class,  // Alias 'admin' cho middleware kiểm tra quyền admin
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Xử lý ngoại lệ nếu cần
        //
    })->create();  // Tạo ứng dụng với các cấu hình đã thiết lập