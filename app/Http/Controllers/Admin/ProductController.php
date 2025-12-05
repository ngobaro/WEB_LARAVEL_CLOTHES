<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('discount')->latest()->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $discounts = Discount::orderBy('code')->get();
        return view('admin.products.create', compact('discounts'));
    }

    // STORE – ĐÃ CHẠY NGON 100% TRÊN LARAVEL 12 + PHP 8.4 + WINDOWS + LARAGON
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:products,name',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'discount_id' => 'nullable|exists:discounts,id',
        ]);

        $data = $request->only(['name', 'price', 'description', 'stock', 'discount_id']);
        $data['slug'] = Str::slug($request->name);

        // UPLOAD ẢNH – CÁCH DUY NHẤT CHẠY NGON TRÊN MÔI TRƯỜNG CỦA BẠN
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/products'), $filename);
            $data['image_url'] = 'products/' . $filename;
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    public function show(Product $product)
    {
        $product->load('discount');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $discounts = Discount::orderBy('code')->get();
        return view('admin.products.edit', compact('product', 'discounts'));
    }

    // UPDATE – CŨNG DÙNG CÁCH MOVE() ĐỂ TRÁNH LỖI
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:products,name,' . $product->id,
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'discount_id' => 'nullable|exists:discounts,id',
        ]);

        $data = $request->only(['name', 'price', 'description', 'stock', 'discount_id']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Xóa ảnh cũ (dùng move nên xóa thủ công)
            if ($product->image_url && file_exists(storage_path('app/public/' . $product->image_url))) {
                @unlink(storage_path('app/public/' . $product->image_url));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/products'), $filename);
            $data['image_url'] = 'products/' . $filename;
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy(Product $product)
    {
        // Xóa ảnh thủ công
        if ($product->image_url && file_exists(storage_path('app/public/' . $product->image_url))) {
            @unlink(storage_path('app/public/' . $product->image_url));
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }

    // XÓA NHIỀU SẢN PHẨM
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            $products = Product::whereIn('id', $ids)->get();
            foreach ($products as $product) {
                if ($product->image_url && file_exists(storage_path('app/public/' . $product->image_url))) {
                    @unlink(storage_path('app/public/' . $product->image_url));
                }
                $product->delete();
            }
        }

        return response()->json(['success' => true, 'message' => 'Đã xóa các sản phẩm được chọn!']);
    }

    // TÌM KIẾM + LỌC
    public function search(Request $request)
    {
        $query = Product::query()->with('discount');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->filled('discount_id')) {
            $query->where('discount_id', $request->discount_id);
        }

        $products = $query->latest()->paginate(12);
        $products->appends($request->all());

        return view('admin.products.index', compact('products'));
    }
}