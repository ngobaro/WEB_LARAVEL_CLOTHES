<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Hiển thị danh sách người dùng (chỉ customer và admin).
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['customer', 'admin']);
        
        // Lọc theo tên
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        // Lọc theo email
        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        
        // Lọc theo role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->latest()->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Hiển thị form tạo người dùng mới.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Lưu người dùng mới - chỉ customer và admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Thêm người dùng thành công!');
    }

    /**
     * Hiển thị chi tiết người dùng.
     */
    public function show(User $user)
    {
        // Chỉ hiển thị nếu là customer hoặc admin
        if (!in_array($user->role, ['customer', 'admin'])) {
            abort(404);
        }
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * Hiển thị form chỉnh sửa người dùng.
     */
    public function edit(User $user)
    {
        // Chỉ chỉnh sửa nếu là customer hoặc admin
        if (!in_array($user->role, ['customer', 'admin'])) {
            abort(404);
        }
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Cập nhật người dùng - chỉ customer và admin.
     */
    public function update(Request $request, User $user)
    {
        // Chỉ cập nhật nếu là customer hoặc admin
        if (!in_array($user->role, ['customer', 'admin'])) {
            abort(404);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:customer,admin',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Chỉ cập nhật password nếu có
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Cập nhật người dùng thành công!');
    }

    /**
     * Xóa người dùng.
     */
    public function destroy(User $user)
    {
        // Không cho xóa chính mình
        if ($user->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Bạn không thể xóa chính mình!');
        }
        
        // Chỉ xóa nếu là customer hoặc admin
        if (!in_array($user->role, ['customer', 'admin'])) {
            return redirect()->back()
                ->with('error', 'Không thể xóa người dùng này!');
        }

        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Xóa người dùng thành công!');
    }
}