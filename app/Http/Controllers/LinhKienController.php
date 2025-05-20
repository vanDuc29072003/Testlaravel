<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinhKien;
use App\Models\DonViTinh;
use App\Models\NhaCungCap;
use App\Models\LienKetLKNCC;

class LinhKienController extends Controller
{
    public function index(Request $request)
    {
        $query = LinhKien::with(['donViTinh', 'nhaCungCaps']); // Eager load quan hệ đơn vị tính và nhà cung cấp

        // Danh sách các trường cần lọc
        $filters = [
            'MaLinhKien' => '=',
            'TenLinhKien' => 'like',
            'SoLuong' => '=',
        ];

        // Áp dụng các điều kiện lọc trực tiếp
        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }

        // Tìm kiếm theo tên đơn vị tính
        if ($request->filled('TenDonViTinh')) {
            $query->whereHas('donViTinh', function ($q) use ($request) {
                $q->where('TenDonViTinh', 'like', '%' . $request->TenDonViTinh . '%');
            });
        }

        // Tìm kiếm theo tên nhà cung cấp
        if ($request->filled('TenNhaCungCap')) {
            $query->whereHas('nhaCungCaps', function ($q) use ($request) {
                $q->where('TenNhaCungCap', 'like', '%' . $request->TenNhaCungCap . '%');
            });
        }

        // Lấy danh sách linh kiện với phân trang
        $dsLinhKien = $query->paginate(10);

        return view('vLK.linhkien', compact('dsLinhKien'));
    }

    public function create()
    {
        $donViTinhs = DonViTinh::all();
        $nhaCungCaps = NhaCungCap::all();
        return view('vLK.addlk', compact('donViTinhs', 'nhaCungCaps'));
    }


    public function store(Request $request)
    {

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'TenLinhKien' => 'required|string|max:255',
            'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap', // Chỉ chọn một nhà cung cấp
            'SoLuong' => 'required|integer|min:1',
            'MoTa' => 'nullable|string|max:255',
            'MaDonViTinh' => 'required',

        ]);

        // Tạo mới linh kiện
        $linhKien = LinhKien::create([
            'TenLinhKien' => $request->TenLinhKien,
            'SoLuong' => $request->SoLuong,
            'MoTa' => $request->MoTa,
            'MaDonViTinh' => $request->MaDonViTinh,
        ]);

        // Lưu quan hệ với nhà cung cấp
        $linhKien->nhaCungCaps()->attach($request->MaNhaCungCap, []);


        return redirect()->route('linhkien')->with('success', 'Thêm linh kiện thành công!');
    }

    public function detail($MaLinhKien)
    {
        $linhKien = LinhKien::with('nhaCungCaps')->findOrFail($MaLinhKien);
        return view('vLK.detailLK', compact('linhKien'));
    }

    public function editForm($MaLinhKien)
    {
        $linhKien = LinhKien::with('nhaCungCaps')->findOrFail($MaLinhKien);
        $donViTinhs = DonViTinh::all();
        $nhaCungCaps = NhaCungCap::all();

        // Lấy danh sách ID nhà cung cấp đã liên kết sẵn
        $selectedNhaCungCaps = $linhKien->nhaCungCaps->pluck('MaNhaCungCap')->toArray();

        return view('vLK.editLK', compact('linhKien', 'donViTinhs', 'nhaCungCaps', 'selectedNhaCungCaps'));
    }

    public function update(Request $request, $MaLinhKien)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'SoLuong' => 'required|integer|min:1',
            'MaNhaCungCap' => 'required|array|min:1', // Phải chọn ít nhất một nhà cung cấp
            'MaNhaCungCap.*' => 'exists:nhacungcap,MaNhaCungCap', // Đảm bảo nhà cung cấp tồn tại
        ]);

        // Tìm linh kiện theo mã
        $linhKien = LinhKien::findOrFail($MaLinhKien);

        // Cập nhật thông tin linh kiện
        $linhKien->update([
            'SoLuong' => $request->SoLuong,
        ]);
        \DB::table('nhacungcap_linhkien')
            ->where('MaLinhKien', $MaLinhKien)
            ->delete();

        // Thêm mới danh sách nhà cung cấp vào bảng liên kết
        $dataInsert = [];
        foreach ($request->MaNhaCungCap as $nhaCungCapId) {
            $dataInsert[] = [
                'MaNhaCungCap' => $nhaCungCapId,
                'MaLinhKien' => $MaLinhKien,

            ];
        }

        // Thêm vào bảng liên kết
        \DB::table('nhacungcap_linhkien')->insert($dataInsert);

        return redirect()->route('linhkien.detail', $MaLinhKien)
            ->with('success', 'Cập nhật linh kiện và nhà cung cấp thành công!');
    }

    public function delete($MaLinhKien)
    {
        $linhKien = LinhKien::findOrFail($MaLinhKien);
        $linhKien->nhaCungCaps()->detach(); // Xóa quan hệ với nhà cung cấp
        $linhKien->delete(); // Xóa linh kiện
        return redirect()->route('linhkien')->with('success', 'Xóa linh kiện thành công!');
    }

    public function search(Request $request)
    {
        $query = LinhKien::query();

        // Lọc theo các trường
        if ($request->filled('MaLinhKien')) {
            $query->where('MaLinhKien', 'like', '%' . $request->MaLinhKien . '%');
        }

        if ($request->filled('TenLinhKien')) {
            $query->where('TenLinhKien', 'like', '%' . $request->TenLinhKien . '%');
        }

        if ($request->filled('SoLuong')) {
            $query->where('SoLuong', $request->SoLuong);
        }

        // Lấy danh sách kết quả
        $dsLinhKien = $query->paginate(10);

        return view('vLK.linhkien', compact('dsLinhKien'));
    }


    public function search1(Request $request)
    {
        $query = $request->query('query');

        $linhKien = LinhKien::with('donViTinh')
            ->where('TenLinhKien', 'like', "%{$query}%")
            ->orWhere('MaLinhKien', 'like', "%{$query}%")
            ->get();

        return response()->json($linhKien);
    }
}