<?php

namespace App\Http\Controllers;

use App\Events\eventUpdateTable;
use App\Models\NhanVien;
use App\Models\NhaCungCap;
use Illuminate\Http\Request;
use App\Models\LichBaoTri;
use App\Models\PhieuBanGiaoBaoTri;
use App\Models\ChiTietPhieuBanGiaoBaoTri;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\May;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LichBaoTriController extends Controller
{


    public function index(Request $request)
    {
        $query = LichBaoTri::query();

        // Chỉ lấy lịch chưa hoàn thành
        $query->where('TrangThai', 0);

        if ($request->filled('khoang_thoi_gian')) {
            $khoang = $request->input('khoang_thoi_gian');

            if ($khoang === '7days') {
                $query->whereBetween('NgayBaoTri', [
                    Carbon::today(),
                    Carbon::today()->addDays(7),
                ]);
            } 
            elseif ($khoang === 'khac') {
                if ($request->filled('tu_ngay') && $request->filled('den_ngay')) {
                    $query->whereBetween('NgayBaoTri', [
                        Carbon::parse($request->input('tu_ngay'))->startOfDay(),
                        Carbon::parse($request->input('den_ngay'))->endOfDay(),
                    ]);
                }
            } 
            else {
                $soThang = (int) $khoang;
                $query->whereBetween('NgayBaoTri', [
                    Carbon::today(),
                    Carbon::today()->addMonths($soThang),
                ]);
            }
        }

        // 3. Mặc định: lọc trong 7 ngày gần nhất
        else {
            $query->whereBetween('NgayBaoTri', [
                Carbon::today(),
                Carbon::today()->addDays(7),
            ]);
        }


        // Lọc theo máy
        if ($request->filled('may_id')) {
            $query->where('MaMay', $request->input('may_id'));
        }

        // Lọc theo nhà cung cấp
        if ($request->filled('ncc_id')) {
            $query->whereHas('may', function ($q) use ($request) {
                $q->where('MaNhaCungCap', $request->input('ncc_id'));
            });
        }

        // Lấy danh sách lịch
        $lichbaotri = $query->with('may.nhacungcap')
            ->orderBy('NgayBaoTri', 'asc')
            ->get();

        // Nhóm theo tháng-năm
        $lichbaotriGrouped = $lichbaotri->groupBy(function ($item) {
            return Carbon::parse($item->NgayBaoTri)->format('Y-m');
        });

        // Dữ liệu combobox
        $dsMay = May::where('TrangThai', '!=', 1)->get();
        $dsNhaCungCap = NhaCungCap::all();

        return view('vLich.lichbaotri', compact('lichbaotriGrouped', 'dsMay', 'dsNhaCungCap'));
    }

    public function lichSuBaoTri(Request $request)
    {
        $query = LichBaoTri::query();

        // Chỉ lấy lịch bảo trì đã hoàn thành
        $query->where('TrangThai', 1);

      
        if ($request->filled('may')) {
            $query->where('MaMay', $request->input('may'));
        }

     
        if ($request->filled('ncc')) {
            $query->whereHas('may', function ($q) use ($request) {
                $q->where('MaNhaCungCap', $request->input('ncc'));
            });
        }

       
        $timeType = $request->input('time_type', 'month');
        if ($timeType === 'month') {
            $query->whereMonth('NgayBaoTri', now()->month)
                ->whereYear('NgayBaoTri', now()->year);
        } elseif ($timeType === 'quarter') {
            ;
            $ketthuc = now()->month;
            $batdau = $ketthuc - 2;
            $query->whereYear('NgayBaoTri', now()->year)
                ->whereMonth('NgayBaoTri', '>=', $batdau)
                ->whereMonth('NgayBaoTri', '<=', $ketthuc);
        } elseif ($timeType === 'custom') {
            if ($request->filled('from') && $request->filled('to')) {
                $from = Carbon::parse($request->input('from'))->startOfDay();
                $to = Carbon::parse($request->input('to'))->endOfDay();
                $query->whereBetween('NgayBaoTri', [$from, $to]);
            }
        }

        
        $lichbaotri = $query->with('may.nhaCungCap')->orderBy('NgayBaoTri', 'desc')->get();

        
        $lichbaotriGrouped = $lichbaotri->groupBy(function ($item) {
            return Carbon::parse($item->NgayBaoTri)->format('Y-m');
        });

      
        $dsMay = May::where('TrangThai', '!=', 1)->get();
        $dsNhaCungCap = NhaCungCap::all();

        return view('vLichSu.lichsubaotri', compact('lichbaotriGrouped', 'dsMay', 'dsNhaCungCap'));
    }



    public function create()
    {

        $machines = May::where('TrangThai', '!=', 1)->get(); // Lấy danh sách máy để hiển thị trong form
        return view('vLich.createlichbaotri', compact('machines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'MoTa' => 'required|string',
            'NgayBaoTri' => 'required|date',
            'MaMay' => 'required|exists:may,MaMay',
        ]);

        $isDotXuat = $request->boolean('is_dot_xuat');
        $isDinhKy = $request->boolean('is_dinh_ky');
        $ngayBaoTri = Carbon::parse($validated['NgayBaoTri'])->format('Y-m-d');

        if ($isDinhKy) {
            // Kiểm tra nếu máy đã có bất kỳ lịch bảo trì nào thì không cho thêm lịch định kỳ
            $daCoLich = LichBaoTri::where('MaMay', $validated['MaMay'])->exists();
            if ($daCoLich) {
                return redirect()->route('lichbaotri.create')
                    ->with('error', 'Máy đã có lịch bảo trì. Không thể tạo lịch bảo trì định kỳ.');
            }

            // Lấy thông tin chu kỳ và thời gian bảo hành
            $may = DB::table('may')
                ->where('MaMay', $validated['MaMay'])
                ->select('ChuKyBaoTri', 'ThoiGianBaoHanh')
                ->first();

            if (!$may || !$may->ChuKyBaoTri || !$may->ThoiGianBaoHanh) {
                return redirect()->back()->with('error', 'Không đủ thông tin chu kỳ hoặc thời gian bảo hành của máy.');
            }
            $thangHienTai = Carbon::now()->month;
            $soLanLap = floor((13 - $thangHienTai) / $may->ChuKyBaoTri);
            if ($soLanLap < 1) {
                return redirect()->route('lichbaotri.create')
                    ->withInput()
                    ->with('error', 'Thời gian bảo hành không đủ để lên lịch bảo trì theo chu kỳ.');
            }

            $ngayLap = Carbon::parse($validated['NgayBaoTri']);
            $soLanLapThanhCong = 0;
            $loiTrungLichVanHanh = [];

            for ($i = 0; $i < $soLanLap; $i++) {
                $ngayLapFormatted = $ngayLap->format('Y-m-d');

                // Kiểm tra trùng lịch vận hành
                $trungVoiVanHanh = DB::table('lichvanhanh')
                    ->where('MaMay', $validated['MaMay'])
                    ->whereDate('NgayVanHanh', $ngayLapFormatted)
                    ->exists();

                if ($trungVoiVanHanh) {
                    $loiTrungLichVanHanh[] = $ngayLap->format('d/m/Y');
                    $ngayLap->addMonths($may->ChuKyBaoTri);
                    continue;
                }

                LichBaoTri::create([
                    'MoTa' => $validated['MoTa'],
                    'NgayBaoTri' => $ngayLapFormatted,
                    'MaMay' => $validated['MaMay'],
                    'TrangThai' => 0,
                ]);

                $soLanLapThanhCong++;
                $ngayLap->addMonths($may->ChuKyBaoTri);
            }

            if ($soLanLapThanhCong === 0) {
                return redirect()->route('lichbaotri.create')
                    ->with('error', 'Tất cả các ngày định kỳ đều trùng với lịch vận hành. Không tạo được lịch bảo trì nào.');
            }

            if (!empty($loiTrungLichVanHanh)) {
                return redirect()->route('lichbaotri')
                    ->with('warning', 'Tạo được ' . $soLanLapThanhCong . ' lịch bảo trì định kỳ. Một số ngày trùng với lịch vận hành:<br>' . implode('<br>', $loiTrungLichVanHanh));
            }

            event(new eventUpdateTable());

            return redirect()->route('lichbaotri')
                ->with('success', "Tạo lịch bảo trì định kỳ thành công ($soLanLapThanhCong lần)!");
        }

        if ($isDotXuat) {
            // Kiểm tra trùng với lịch bảo trì
            $trungNgay = LichBaoTri::where('MaMay', $validated['MaMay'])
                ->whereDate('NgayBaoTri', $ngayBaoTri)
                ->exists();

            // Kiểm tra trùng với lịch vận hành
            $trungVoiVanHanh = DB::table('lichvanhanh')
                ->where('MaMay', $validated['MaMay'])
                ->whereDate('NgayVanHanh', $ngayBaoTri)
                ->exists();

            if ($trungNgay) {
                return redirect()->route('lichbaotri.create')
                    ->with('error', 'Đã tồn tại lịch bảo trì cho máy này vào ngày đã chọn.');
            }

            if ($trungVoiVanHanh) {
                return redirect()->route('lichbaotri.create')
                    ->with('error', 'Máy này đang có lịch vận hành vào ngày đã chọn. Không thể tạo lịch bảo trì.');
            }

            LichBaoTri::create([
                'MoTa' => $validated['MoTa'],
                'NgayBaoTri' => $ngayBaoTri,
                'MaMay' => $validated['MaMay'],
                'TrangThai' => 0,
            ]);

            event(new eventUpdateTable());

            return redirect()->route('lichbaotri')->with('success', 'Tạo lịch bảo trì đột xuất thành công!');
        }

        return redirect()->back()->with('error', 'Vui lòng chọn loại lịch bảo trì hợp lệ.');
    }




    function destroy($id)
    {
        $lichbaotri = LichBaoTri::findOrFail($id);
        $lichbaotri->delete();

        event(new eventUpdateTable());

        return redirect()->back()->with('success', 'Xóa lịch bảo trì thành công!');
    }

    public function exporttscBT($MaLichBaoTri)
    {
       
        $lich = LichBaoTri::with(['may'])->where('MaLichBaoTri', $MaLichBaoTri)->firstOrFail();

        // Tạo PDF từ view
        $pdf = PDF::loadView('vLich.exporttscBT', compact('lich'));

        // Stream PDF (hiển thị trực tiếp trên trình duyệt)
        return $pdf->stream('LichBaoTri_' . $MaLichBaoTri . '.pdf');
    }


    public function taophieubangiao($lichbaotri)
    {
        $lichbaotri = LichBaoTri::findOrFail($lichbaotri);
        $may = May::findOrFail($lichbaotri->MaMay);
        $lichbaotri->load('may.nhaCungCap');
        $nhaCungCap = $may->nhaCungCap;

        //Kiểm tra ngày hết hạn bảo hành
        $ngayHetBaoHanh = null;
        if ($may->ThoiGianDuaVaoSuDung && $may->ThoiGianBaoHanh) {
            $ngayHetBaoHanh = Carbon::parse($may->ThoiGianDuaVaoSuDung)->addMonths($may->ThoiGianBaoHanh);
        }
        if (!$nhaCungCap) {
            return redirect()->back()->with('error', 'Không tìm thấy thông tin nhà cung cấp.');
        }
        $nhanvien = Auth::user();
        return view('vPhieuBanGiao.pbgBT', compact('lichbaotri', 'may', 'nhaCungCap', 'nhanvien', 'ngayHetBaoHanh'));
    }

    public function show($MaLichBaoTri)
    {
        $lichBaoTri = LichBaoTri::with([
            'may.nhaCungCap',
            'phieuBanGiaoBaoTri.chiTietPhieuBanGiaoBaoTri',
            'phieuBanGiaoBaoTri.nhanVien'
        ])->findOrFail($MaLichBaoTri);

       
        $nhaCungCap = $lichBaoTri->may->nhaCungCap;
        $nhanvien = $lichBaoTri->phieuBanGiaoBaoTri ? $lichBaoTri->phieuBanGiaoBaoTri->nhanVien : null;

        return view('vPhieuBanGiao.detailpbgBT', compact('lichBaoTri', 'nhaCungCap', 'nhanvien'));
    }
    public function edit($id)
    {
        $lich = LichBaoTri::with('may.nhaCungCap')->findOrFail($id);
        return view('Vlich.editlichbaotri', compact('lich'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'NgayBaoTri' => 'required|date',
        ]);

        $lich = LichBaoTri::findOrFail($id);
        $lich->NgayBaoTri = $request->NgayBaoTri;
        $lich->save();

        event(new eventUpdateTable());

        return redirect()->route('lichbaotri')->with('success', 'Cập nhật lịch bảo trì thành công.');
    }


}
