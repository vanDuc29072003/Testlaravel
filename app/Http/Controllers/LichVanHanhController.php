<?php

namespace App\Http\Controllers;

use App\Models\LichVanHanh;
use App\Models\May;
use App\Models\NhanVien;
use App\Events\eventUpdateTable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;

class LichVanHanhController extends Controller
{
    public function index(Request $request)
    {
        $query = LichVanHanh::query();
        $may = May::where('TrangThai', '!=', 1)->get();
        $nhanvien = NhanVien::all();

        // Lọc theo bộ lọc thời gian
        $timeFilter = $request->input('time_filter', 'today');

        switch ($timeFilter) {
            case 'today':
                $query->whereDate('NgayVanHanh', Carbon::today());
                break;
            case 'yesterday':
                $query->whereDate('NgayVanHanh', Carbon::yesterday());
                break;
            case 'tomorrow':
                $query->whereDate('NgayVanHanh', Carbon::tomorrow());
                break;
            case 'this_week':
                // Lọc từ thứ 2 đầu tuần đến chủ nhật cuối tuần (tùy thiết lập vùng, mặc định Carbon tuần bắt đầu từ thứ 2)
                $query->whereBetween('NgayVanHanh', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'custom':
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    try {
                        $fromDate = Carbon::parse($request->input('start_date'))->startOfDay();
                        $toDate = Carbon::parse($request->input('end_date'))->endOfDay();
                        $query->whereBetween('NgayVanHanh', [$fromDate, $toDate]);
                    } catch (\Exception $e) {
                        return redirect()->back()->withErrors(['error' => 'Định dạng ngày không hợp lệ!']);
                    }
                }
                break;
            default:
                // Mặc định là hôm nay nếu time_filter không hợp lệ
                $query->whereDate('NgayVanHanh', Carbon::today());
        }

        // Lọc ca làm việc
        if ($request->filled('ca')) {
            $query->where('CaLamViec', $request->input('ca'));
        }
        // Lọc máy
        if ($request->filled('may')) {
            $query->where('MaMay', $request->input('may'));
        }
        // Lọc nhân viên
        if ($request->filled('nhanvien')) {
            $query->where('MaNhanVien', $request->input('nhanvien'));
        }

        $lichvanhanh = $query->with(['may', 'nhanVien'])->orderBy('NgayVanHanh', 'asc')->get()->groupBy('NgayVanHanh');

        return view('Vlich.lichvanhanh', compact('lichvanhanh', 'may', 'nhanvien'));
    }




    public function create()
    {
        $may = May::where('TrangThai', '!=', 1)->get();
        $nhanvien = NhanVien::where('MaBoPhan', 2)->get();

        return view('Vlich.createlichvanhanh', compact('may', 'nhanvien'));
    }

    public function store(Request $request)
    {
        $kieuLich = $request->kieuLich;

        // Validate chung
        $request->validate([
            'kieuLich' => 'required|in:tuan,ngay',
            'entries' => 'required|array|min:1',
            'entries.*.MaMay' => 'required',
            'entries.*.MaNhanVien' => 'required',
            'entries.*.CaLamViec' => 'required',
        ]);

        $daysInWeek = collect();

        // Lấy danh sách ngày
        if ($kieuLich === 'tuan') {
            $thang = $request->thang;
            $nam = $request->nam;
            $tuan = $request->tuan;

            $startOfMonth = Carbon::create($nam, $thang, 1);
            $firstMonday = $startOfMonth->copy()->startOfWeek(Carbon::MONDAY);
            if ($firstMonday->month != $thang) {
                $firstMonday = $firstMonday->copy()->addWeek();
            }
            $startOfWeek = $firstMonday->copy()->addWeeks($tuan - 1);

            for ($i = 0; $i < 7; $i++) {
                $daysInWeek->push($startOfWeek->copy()->addDays($i));
            }
        } elseif ($kieuLich === 'ngay') {
            $request->validate([
                'ngayDotXuat' => 'required|date',
            ]);
            $ngayDotXuat = Carbon::parse($request->ngayDotXuat);
            $daysInWeek->push($ngayDotXuat);
        }

        $loiTrungLich = [];
        $soLuongLichDuocThem = 0;

        foreach ($request->entries as $entry) {
            foreach ($daysInWeek as $day) {
                $ngay = $day->format('Y-m-d');

                // Kiểm tra lịch vận hành
                $lichVanHanhExists = DB::table('lichvanhanh')
                    ->whereDate('NgayVanHanh', $ngay)
                    ->where('MaMay', $entry['MaMay'])
                    ->where('CaLamViec', $entry['CaLamViec'])
                    ->exists();

                // Kiểm tra lịch bảo trì
                $lichBaoTriExists = DB::table('lichbaotri')
                    ->whereDate('NgayBaoTri', $ngay)
                    ->where('MaMay', $entry['MaMay'])
                    ->exists();

                if ($lichVanHanhExists || $lichBaoTriExists) {
                    $tenMay = DB::table('may')->where('MaMay', $entry['MaMay'])->value('TenMay');
                    $loiTrungLich[] = 'Ngày ' . $day->format('d/m/Y') . ' - Máy: ' . ($tenMay ?? $entry['MaMay']);
                    continue;
                }

                // Thêm lịch
                DB::table('lichvanhanh')->insert([
                    'NgayVanHanh' => $ngay,
                    'MaMay' => $entry['MaMay'],
                    'MaNhanVien' => $entry['MaNhanVien'],
                    'CaLamViec' => $entry['CaLamViec'],
                    'MoTa' => $entry['MoTa'] ?? null,
                ]);

                $soLuongLichDuocThem++;
            }
        }

        // Xử lý thông báo và chuyển trang
        if (!empty($loiTrungLich)) {
            if ($soLuongLichDuocThem > 0) {
                return redirect()->route('lichvanhanh')->with('notify_messages', [
                    ['type' => 'success', 'message' => 'Đã thêm ' . $soLuongLichDuocThem . ' lịch thành công.'],
                    ['type' => 'warning', 'message' => 'Một số lịch bị trùng:<br>' . implode('<br>', $loiTrungLich)]
                ]);
            } else {
                return redirect()->back()->withInput()->with('notify_messages', [
                    ['type' => 'warning', 'message' => 'Tất cả lịch đều bị trùng. Không có lịch nào được thêm.<br>' . implode('<br>', $loiTrungLich)]
                ]);
            }
        }

        event(new eventUpdateTable());

        return redirect()->route('lichvanhanh')->with('notify_messages', [
            ['type' => 'success', 'message' => 'Thêm tất cả lịch thành công!']
        ]);
    }




    public function edit($id)
    {
        $lich = LichVanHanh::findOrFail($id);
        $may = May::where('TrangThai', '!=', 1)->get();
        $nhanvien = NhanVien::all();
        return view('Vlich.editlichvanhanh', compact('lich', 'may', 'nhanvien'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'MaMay' => 'required',
            'MaNhanVien' => 'required',
            'MoTa' => 'nullable|string',
            'CaLamViec' => 'required|in:Sáng,Chiều,Đêm',
        ]);

        $lich = LichVanHanh::findOrFail($id);
        $lich->update($request->all());

        event(new eventUpdateTable());

        return redirect()->route('lichvanhanh')->with('success', 'Cập nhật thành công!');
    }
    public function showNhatKi($id)
    {
        
        $lich = LichVanHanh::with(['may', 'nhanVien'])->findOrFail($id);
        
        return view('vLich.nhatkivanhanh', compact('lich'));
    }
    public function updateNhatKi(Request $request, $id)
    {
 
        $trangThai = is_array($request->TrangThai)
            ? (int) $request->TrangThai[0]  
            : (int) $request->TrangThai;

        // Xác thực dữ liệu
        if (!in_array($trangThai, [0, 2])) {
            return back()->withErrors(['TrangThai' => 'Trạng thái không hợp lệ.']);
        }

        $request->validate([
            'NhatKi' => 'required|string',
            'TrangThai' => 'required|in:0,2',
            'MoTaSuCo' => $trangThai === 2 ? 'required|string' : 'nullable|string',

        ]);

        // Cập nhật nhật ký
        $lich = LichVanHanh::findOrFail($id);
        $lich->NhatKi = $request->NhatKi;
        $lich->trangthai = $trangThai; 
        $lich->MoTaSuCo = $request->MoTaSuCo;
        $lich->save();


        return redirect()->route('lichvanhanh')->with('success', 'Đã lưu nhật ký và cập nhật trạng thái máy thành công!');
    }


    public function destroy(Request $request, $id)
    {

        $lich = LichVanHanh::findOrFail($id);
        $lich->delete();

        event(new eventUpdateTable());

        return redirect()->back()->with('success', 'Xóa lịch vận hành thành công!');
    }
}
