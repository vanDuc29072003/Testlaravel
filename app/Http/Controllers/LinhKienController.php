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
        $query = LinhKien::with(['donViTinh', 'nhaCungCaps']);

        $filters = [
            'MaLinhKien' => '=',
            'TenLinhKien' => 'like',
            'SoLuong' => '=',
            'MaDonViTinh' => '=',
        ];

        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }

        if ($request->filled('MaNhaCungCap')) {
            $query->whereHas('nhaCungCaps', function ($q) use ($request) {
                $q->where('nhacungcap_linhkien.MaNhaCungCap', $request->MaNhaCungCap);
            });
        }

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

            $linhKien->nhaCungCaps()->attach($request->MaNhaCungCap, []);

            return redirect()->route('linhkien')->with('success', 'Thêm linh kiện mới thành công !');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Tạo linh kiện không thành công, vui lòng kiểm tra lại.');
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
            $linhKien->nhaCungCaps()->attach($request->MaNhaCungCap, []);
            return redirect()->route('dsphieunhap.add')
                ->with('success', 'Thêm linh kiện thành công, hãy tạo tiếp thông tin phiếu nhập!');


        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Tạo linh kiện không thành công, vui lòng kiểm tra lại.');
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
            $linhKien->nhaCungCaps()->attach($request->MaNhaCungCap, []);
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
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Tạo linh kiện không thành công, vui lòng kiểm tra lại.');
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
        $formData = session('formData');
        $selectedNhaCungCaps = $formData['MaNhaCungCap'] ?? $linhKien->nhaCungCaps->pluck('MaNhaCungCap')->toArray();

        return view('vLK.editLK', compact('linhKien', 'donViTinhs', 'nhaCungCaps', 'formData', 'selectedNhaCungCaps'));

    }

    public function update(Request $request, $MaLinhKien)
    {
        try {
            $request->validate([
                'MoTa' => 'nullable|string|max:255',
                'MaDonViTinh' => 'required|exists:donvitinh,MaDonViTinh',
                'TenLinhKien' => 'required|string|max:255|unique:linhkiensuachua,TenLinhKien,' . $MaLinhKien . ',MaLinhKien',
                'MaNhaCungCap' => 'required|array|min:1',
                'MaNhaCungCap.*' => 'exists:nhacungcap,MaNhaCungCap',
            ], [
                'TenLinhKien.unique' => 'Tên linh kiện đã tồn tại trong hệ thống.',
            ]);

            $linhKien = LinhKien::findOrFail($MaLinhKien);

            $linhKien->update([
                'TenLinhKien' => $request->TenLinhKien,
                'MoTa' => $request->MoTa,
                'MaDonViTinh' => $request->MaDonViTinh,
            ]);

            //cập nhật danh sách nhà cung cấp
            $linhKien->nhaCungCaps()->sync($request->MaNhaCungCap);

            return redirect()->route('linhkien.detail', $MaLinhKien)
                ->with('success', 'Cập nhật linh kiện thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', $e->validator->errors()->first())
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Cập nhật linh kiện không thành công, vui lòng kiểm tra lại.');
        }
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
        try {
            $linhKien = LinhKien::findOrFail($MaLinhKien);

            $linhKien->delete();
            return redirect()->back()->with('success', 'Xóa linh kiện thành công!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->with('error', 'Không thể xóa linh kiện này vì đang được sử dụng');
        }
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