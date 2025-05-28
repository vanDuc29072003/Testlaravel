<?php

namespace App\Http\Controllers;

use App\Models\LichVanHanh;
use App\Models\May;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;

class LichVanHanhController extends Controller
{
    
  

        public function index(Request $request)
        {
            $query = LichVanHanh::query();
            $may = May::all();
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
        $may = May::all();
        $nhanvien = NhanVien::where('MaBoPhan', 2)->get();

        return view('Vlich.createlichvanhanh', compact('may', 'nhanvien'));
    }

    public function store(Request $request)
    {
        $kieuLich = $request->kieuLich;

        // Validate cơ bản
        $request->validate([
            'kieuLich' => 'required|in:tuan,ngay',
            'entries' => 'required|array|min:1',
            'entries.*.MaMay' => 'required',
            'entries.*.MaNhanVien' => 'required',
            'entries.*.CaLamViec' => 'required',
        ]);

        $daysInWeek = collect();

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
        } 
        else if ($kieuLich === 'ngay') {
            $request->validate([
                'ngayDotXuat' => 'required|date',
            ]);
            $ngayDotXuat = Carbon::parse($request->ngayDotXuat);
            $daysInWeek->push($ngayDotXuat);
        }

        foreach ($request->entries as $entry) {
        foreach ($daysInWeek as $day) {
            $exists = DB::table('lichvanhanh')->whereDate('NgayVanHanh', $day->format('Y-m-d'))
                ->where('MaMay', $entry['MaMay'])
                ->where('CaLamViec', $entry['CaLamViec'])
                ->exists();

            if (!$exists) {
                DB::table('lichvanhanh')->insert([
                    'NgayVanHanh' => $day->format('Y-m-d'),
                    'MaMay' => $entry['MaMay'],
                    'MaNhanVien' => $entry['MaNhanVien'],
                    'CaLamViec' => $entry['CaLamViec'],
                    'MoTa' => $entry['MoTa'] ?? null,
                ]);
            } else {
                // Nếu cần hiển thị lỗi cụ thể:
                return back()->withErrors(['error' => 'Lịch trùng: ' . $day->format('d/m/Y') . ' - Máy: ' . $entry['MaMay'] . ' - Ca: ' . $entry['CaLamViec']]);
            }
        }
    }

        return redirect()->route('lichvanhanh')->with('success', 'Thêm lịch thành công!');
    }


    public function edit($id)
    {
        $lich = LichVanHanh::findOrFail($id);
        $may = May::all();
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

        return redirect()->route('lichvanhanh')->with('success', 'Cập nhật thành công!');
    }
        public function showNhatKi($id)
    {
        // Tìm lịch vận hành theo ID
        $lich = LichVanHanh::with(['may', 'nhanVien'])->findOrFail($id);

        // Trả về view và truyền dữ liệu cho view
        return view('vLich.nhatkivanhanh', compact('lich'));
    }
   public function updateNhatKi(Request $request, $id)
    {
        // Nếu checkbox gửi lên dưới dạng mảng (nhiều checkbox cùng name="TrangThai")
        $trangThai = is_array($request->TrangThai)
            ? (int) $request->TrangThai[0]  // Lấy giá trị đầu tiên được chọn
            : (int) $request->TrangThai;

        // Xác thực dữ liệu
        if (!in_array($trangThai, [0, 2])) {
            return back()->withErrors(['TrangThai' => 'Trạng thái không hợp lệ.']);
        }

        $request->validate([
            'NhatKi' => 'nullable|string',
        ]);

        // Cập nhật nhật ký
        $lich = LichVanHanh::findOrFail($id);
        $lich->NhatKi = $request->NhatKi;
        $lich->trangthai = $trangThai; // Cập nhật trạng thái
        $lich->save();

        // Cập nhật trạng thái máy
        $may = May::where('MaMay', $lich->MaMay)->first();
        if ($may) {
            $may->TrangThai = $trangThai;
            $may->save();
        }

        return redirect()->route('lichvanhanh')->with('success', 'Đã lưu nhật ký và cập nhật trạng thái máy thành công!');
    }

    



    public function destroy(Request $request,$id)
    {
        
        $lich = LichVanHanh::findOrFail($id);
        $lich->delete();

        // Lấy lại các tham số lọc từ request
        $filters = $request->only(['from_date', 'to_date', 'quy', 'nam', 'ca']);

    // Chuyển hướng lại với các tham số lọc
        return redirect()->route('lichvanhanh', $filters)->with('success', 'Xóa thành công!');
    }
}
