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
    /**
     * Hiển thị danh sách sản phẩm.
     *
     * Mô tả:
     * - Lấy tất cả sản phẩm từ cơ sở dữ liệu cùng với thông tin giảm giá.
     * - Sản phẩm được sắp xếp theo thời gian tạo và phân trang 12 sản phẩm mỗi trang.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Lấy danh sách sản phẩm cùng thông tin giảm giá, sắp xếp mới nhất và phân trang (12 sản phẩm/trang)
        $products = Product::with('discount')->latest()->paginate(12);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Hiển thị form để tạo sản phẩm mới.
     *
     * Mô tả:
     * - Lấy danh sách mã giảm giá để hiển thị trong form tạo sản phẩm.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Lấy danh sách các mã giảm giá, sắp xếp theo mã giảm giá để hiển thị trong form tạo sản phẩm
        $discounts = Discount::orderBy('code')->get();
        return view('admin.products.create', compact('discounts'));
    }

    /**
     * Lưu sản phẩm mới vào cơ sở dữ liệu.
     *
     * Mô tả:
     * - Xác thực dữ liệu đầu vào từ request.
     * - Tạo slug từ tên sản phẩm và lưu thông tin sản phẩm vào cơ sở dữ liệu.
     * - Nếu có ảnh, thực hiện upload và lưu đường dẫn vào cơ sở dữ liệu.
     * - Redirect về trang danh sách sản phẩm với thông báo thành công.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name'        => 'required|string|max:255|unique:products,name',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'discount_id' => 'nullable|exists:discounts,id',
        ]);

        // Chọn dữ liệu cần thiết để lưu vào cơ sở dữ liệu
        $data = $request->only(['name', 'price', 'description', 'stock', 'discount_id']);
        // Tạo slug từ tên sản phẩm
        $data['slug'] = Str::slug($request->name);

        // Kiểm tra xem có file hình ảnh không, nếu có thì thực hiện việc upload hình
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Di chuyển file vào thư mục 'products' trong storage
            $file->move(storage_path('app/public/products'), $filename);
            // Lưu đường dẫn hình ảnh vào cơ sở dữ liệu
            $data['image_url'] = 'products/' . $filename;
        }

        // Tạo mới sản phẩm trong cơ sở dữ liệu
        Product::create($data);

        // Redirect về danh sách sản phẩm với thông báo thành công
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công!');
    }

    /**
     * Hiển thị thông tin chi tiết của sản phẩm.
     *
     * Mô tả:
     * - Tải sản phẩm và thông tin giảm giá liên quan để hiển thị chi tiết.
     *
     * @param Product $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        // Tải thông tin sản phẩm và thông tin giảm giá liên quan
        $product->load('discount');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Hiển thị form để chỉnh sửa sản phẩm.
     *
     * Mô tả:
     * - Lấy sản phẩm cụ thể và danh sách giảm giá để chỉnh sửa.
     *
     * @param Product $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        // Lấy danh sách mã giảm giá để hiển thị trong form chỉnh sửa
        $discounts = Discount::orderBy('code')->get();
        return view('admin.products.edit', compact('product', 'discounts'));
    }

    /**
     * Cập nhật thông tin sản phẩm.
     *
     * Mô tả:
     * - Xác thực dữ liệu đầu vào.
     * - Cập nhật sản phẩm và đường dẫn ảnh nếu có ảnh mới được tải lên.
     * - Xóa ảnh cũ nếu có trước khi cập nhật.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name'        => 'required|string|max:255|unique:products,name,' . $product->id,
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'discount_id' => 'nullable|exists:discounts,id',
        ]);

        // Chọn các dữ liệu cần thiết
        $data = $request->only(['name', 'price', 'description', 'stock', 'discount_id']);
        $data['slug'] = Str::slug($request->name);

        // Kiểm tra xem có file hình ảnh mới không
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            // Xóa ảnh cũ nếu có
            if ($product->image_url && file_exists(storage_path('app/public/' . $product->image_url))) {
                @unlink(storage_path('app/public/' . $product->image_url));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path('app/public/products'), $filename);
            // Cập nhật đường dẫn hình ảnh mới
            $data['image_url'] = 'products/' . $filename;
        }

        // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
        $product->update($data);

        // Redirect về danh sách sản phẩm với thông báo thành công
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công!');
    }

    /**
     * Xóa sản phẩm khỏi cơ sở dữ liệu.
     *
     * Mô tả:
     * - Xóa ảnh liên quan trước khi xóa sản phẩm.
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        // Xóa ảnh có liên quan trước khi xóa sản phẩm
        if ($product->image_url && file_exists(storage_path('app/public/' . $product->image_url))) {
            @unlink(storage_path('app/public/' . $product->image_url));
        }

        // Xóa sản phẩm khỏi cơ sở dữ liệu
        $product->delete();

        // Redirect về danh sách sản phẩm với thông báo thành công
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công!');
    }

    /**
     * Xóa nhiều sản phẩm theo yêu cầu.
     *
     * Mô tả:
     * - Lấy danh sách các ID sản phẩm từ request và xóa từng sản phẩm.
     * - Xóa ảnh đi kèm với sản phẩm mỗi khi sản phẩm bị xóa.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(Request $request)
    {
        // Lấy danh sách ID từ request
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            // Lấy các sản phẩm tương ứng từ cơ sở dữ liệu
            $products = Product::whereIn('id', $ids)->get();
            foreach ($products as $product) {
                // Xóa ảnh có liên quan trước khi xóa sản phẩm
                if ($product->image_url && file_exists(storage_path('app/public/' . $product->image_url))) {
                    @unlink(storage_path('app/public/' . $product->image_url));
                }
                // Xóa sản phẩm
                $product->delete();
            }
        }

        // Trả về phản hồi JSON với thông báo thành công
        return response()->json(['success' => true, 'message' => 'Đã xóa các sản phẩm được chọn!']);
    }

    /**
     * Tìm kiếm và lọc sản phẩm theo tên và mã giảm giá.
     *
     * Mô tả:
     * - Nếu có thông tin tìm kiếm, lọc danh sách sản phẩm theo tên và mã giảm giá.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        // Khởi tạo truy vấn cho sản phẩm
        $query = Product::query()->with('discount');

        // Lọc theo tên sản phẩm nếu có
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        // Lọc theo mã giảm giá nếu có
        if ($request->filled('discount_id')) {
            $query->where('discount_id', $request->discount_id);
        }

        // Sắp xếp mới nhất và phân trang
        $products = $query->latest()->paginate(12);
        $products->appends($request->all());

        return view('admin.products.index', compact('products'));
    }
}