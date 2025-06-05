<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinhKien;
use App\Models\DonViTinh;
use App\Models\NhaCungCap;
use App\Models\LienKetLKNCC;
use Illuminate\Support\Facades\DB;

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
            'MaDonViTinh' => '=',
        ];

        // Áp dụng các điều kiện lọc trực tiếp
        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }

        // Tìm kiếm theo tên nhà cung cấp
        if ($request->filled('MaNhaCungCap')) {
            $query->whereHas('nhaCungCaps', function ($q) use ($request) {
                $q->where('nhacungcap_linhkien.MaNhaCungCap', $request->MaNhaCungCap);
            });
        }

        // Lấy danh sách linh kiện với phân trang
        $dsLinhKien = $query->paginate(10);
        $dsDonViTinh = DonViTinh::all();
        $dsNhaCungCap = NhaCungCap::all();

        return view('vLK.linhkien', compact('dsLinhKien', 'dsDonViTinh', 'dsNhaCungCap'));
    }

    public function create()
    {
        $donViTinhs = DonViTinh::all();
        $nhaCungCaps = NhaCungCap::all();
        $linhkienFormData = session('linhkien_form_data', []);
        session()->forget('linhkien_form_data');

        return view('vLK.addlk', compact('donViTinhs', 'nhaCungCaps', 'linhkienFormData'));
    }
    public function create2()
    {
        $donViTinhs = DonViTinh::all();
        $nhaCungCaps = NhaCungCap::all();
        return view('vLK.addlk2', compact('donViTinhs', 'nhaCungCaps'));
    }
    public function create3()
    {
        $donViTinhs = DonViTinh::all();
        $nhaCungCaps = NhaCungCap::all();
        return view('vLK.addlk3', compact('donViTinhs', 'nhaCungCaps'));
    }

    public function store(Request $request)
    {
        try {
            // Xác thực dữ liệu đầu vào
            $request->validate(
                [
                    'TenLinhKien' => 'required|string|max:255|unique:linhkiensuachua,TenLinhKien',
                    'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap', // Chỉ chọn một nhà cung cấp
                    'MoTa' => 'nullable|string|max:255',
                    'MaDonViTinh' => 'required',

                ],
                [
                    'TenLinhKien.unique' => 'Tên linh kiện đã tồn tại trong hệ thống.',
                ]
            );

            // Tạo mới linh kiện
            $linhKien = LinhKien::create([
                'TenLinhKien' => $request->TenLinhKien,
                'SoLuong' => 0,
                'MoTa' => $request->MoTa,
                'MaDonViTinh' => $request->MaDonViTinh,
            ]);

            // Lưu quan hệ với nhà cung cấp
            $linhKien->nhaCungCaps()->attach($request->MaNhaCungCap, []);


            return redirect()->route('linhkien')->with('success', 'Thêm linh kiện mới thành công !');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first()) // Lấy lỗi đầu tiên     
                ->withInput();
        }
    }
    public function store2(Request $request)
    {
        try {
            $request->validate([
                'TenLinhKien' => 'required|string|max:255|unique:linhkiensuachua,TenLinhKien',
                'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap',
                'MoTa' => 'nullable|string|max:255',
                'MaDonViTinh' => 'required',
            ], [
                'TenLinhKien.unique' => 'Tên linh kiện đã tồn tại trong hệ thống.',
            ]);

            $linhKien = LinhKien::create([
                'TenLinhKien' => $request->TenLinhKien,
                'SoLuong' => 0,
                'MoTa' => $request->MoTa,
                'MaDonViTinh' => $request->MaDonViTinh,
            ]);

            return redirect()->route('dsphieunhap.add')
                ->with('success', 'Thêm linh kiện thành công, hãy tạo tiếp thông tin phiếu nhập!');


        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first())
                ->withInput();
        }
    }
    public function store3(Request $request)
    {
        try {
            $request->validate([

                'TenLinhKien' => 'required|string|max:255|unique:linhkiensuachua,TenLinhKien',
                'MaNhaCungCap' => 'required|exists:nhacungcap,MaNhaCungCap',
                'MoTa' => 'nullable|string|max:255',
                'MaDonViTinh' => 'required',

            ], [
                'TenLinhKien.unique' => 'Tên linh kiện đã tồn tại trong hệ thống.',
            ]);

            $linhKien = LinhKien::create([
                'TenLinhKien' => $request->TenLinhKien,
                'SoLuong' => 0,
                'MoTa' => $request->MoTa,
                'MaDonViTinh' => $request->MaDonViTinh,
            ]);

            $phieuNhapSession1 = session('phieuNhapSession1');

            if (!$phieuNhapSession1 || !isset($phieuNhapSession1['MaPhieuNhap'])) {
                return redirect()->back()->with('error', 'Mã phiếu nhập không tồn tại trong session.');
            }

            $MaPhieuNhap = $phieuNhapSession1['MaPhieuNhap'];

            return redirect()->route('dsphieunhap.edit', ['MaPhieuNhap' => $MaPhieuNhap])
                ->with('success', 'Thêm linh kiện thành công, quay lại chỉnh sửa phiếu nhập!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first())
                ->withInput();
        }
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
        $formData = session('formData'); // lấy từ flash session nếu có
        $selectedNhaCungCaps = $formData['MaNhaCungCap'] ?? $linhKien->nhaCungCaps->pluck('MaNhaCungCap')->toArray();

        return view('vLK.editLK', compact('linhKien', 'donViTinhs', 'nhaCungCaps', 'formData', 'selectedNhaCungCaps'));

    }

    public function update(Request $request, $MaLinhKien)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([

            'MoTa' => 'nullable|string|max:255',
            'MaDonViTinh' => 'required|exists:donvitinh,MaDonViTinh', // Đảm bảo mã đơn vị tính tồn tại
            'TenLinhKien' => 'required|string|max:255',
            'MaNhaCungCap' => 'required|array|min:1', // Phải chọn ít nhất một nhà cung cấp
            'MaNhaCungCap.*' => 'exists:nhacungcap,MaNhaCungCap', // Đảm bảo nhà cung cấp tồn tại
        ]);

        // Tìm linh kiện theo mã
        $linhKien = LinhKien::findOrFail($MaLinhKien);

        // Cập nhật thông tin linh kiện
        $linhKien->update([
            'TenLinhKien' => $request->TenLinhKien,
            'MoTa' => $request->MoTa,
            'MaDonViTinh' => $request->MaDonViTinh,
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
            ->with('success', 'Cập nhật linh kiện thành công!');
    }
    public function saveFormData(Request $request)
    {
        session([
            'form_linhkien_data' => $request->all(),
            'editing_linhkien_id' => $request->MaLinhKien // lưu lại mã linh kiện

        ]);

        return redirect()->route('nhacungcap.add2');
    }

    public function delete($MaLinhKien)
    {
        try{
        $linhKien = LinhKien::findOrFail($MaLinhKien);
       
        $linhKien->delete(); // Xóa linh kiện
        return redirect()->back()->with('success', 'Xóa linh kiện thành công!');
    } catch(\Illuminate\Database\QueryException $e){
            return redirect()->back()->with('error', 'Không thể xóa linh kiện này vì đang được sử dụng');
        }
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
    public function saveFormSession(Request $request)
    {
        session()->put('linhkien_form_data', $request->all());
        return response()->json(['status' => 'ok']);
    }
    
}