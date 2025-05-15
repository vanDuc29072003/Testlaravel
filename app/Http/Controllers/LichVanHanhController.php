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
  
        // Sửa lại xử lý ngày từ form
        if ($request->filled('from_date') && $request->filled('to_date')) {
            try {
                // Trình duyệt mặc định gửi ngày dạng yyyy-mm-dd, nên chỉ cần dùng Carbon::parse()
                $fromDate = Carbon::parse($request->input('from_date'))->startOfDay();
                $toDate = Carbon::parse($request->input('to_date'))->endOfDay();

                $query->whereBetween('NgayVanHanh', [$fromDate, $toDate]);
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['error' => 'Định dạng ngày không hợp lệ!']);
            }
        }


        // Lọc theo quý
        if ($request->filled('quy')) {
            $quy = $request->input('quy');
            $startMonth = ($quy - 1) * 3 + 1;
            $endMonth = $startMonth + 2;
            $query->whereMonth('NgayVanHanh', '>=', $startMonth)
                ->whereMonth('NgayVanHanh', '<=', $endMonth);
        }

        // Lọc theo năm
        if ($request->filled('nam')) {
            $query->whereYear('NgayVanHanh', $request->input('nam'));
        }

        // Lọc theo ca làm việc
        if ($request->filled('ca')) {
            $query->where('CaLamViec', $request->input('ca'));
        }

        // Nếu không có bộ lọc nào, hiển thị dữ liệu của ngày hôm nay
        if (!$request->filled('from_date') && !$request->filled('to_date') && !$request->filled('quy') && !$request->filled('nam') && !$request->filled('ca')) {
            $query->whereDate('NgayVanHanh', Carbon::today());
        }
        if ($request->filled('may')) {
            $query->where('MaMay', $request->input('may'));
        }
        if ($request->filled('nhanvien')) {
            $query->where('MaNhanVien', $request->input('nhanvien'));
        }

        

        $lichvanhanh = $query->with(['may', 'nhanVien'])->orderBy('NgayVanHanh', 'asc')->get()->groupBy('NgayVanHanh');

        return view('Vlich.lichvanhanh', compact('lichvanhanh','may','nhanvien'));
    }
    


    public function create()
    {
        $may = May::all();
        $nhanvien = NhanVien::all();
        return view('Vlich.createlichvanhanh', compact('may', 'nhanvien'));
    }

    public function store(Request $request)
    {
        $thang = $request->thang;
        $nam = $request->nam;
        $tuan = $request->tuan;

        // Tính ngày bắt đầu tuần
        $startOfMonth = Carbon::create($nam, $thang, 1);
        $startOfWeek = $startOfMonth->copy()->addWeeks($tuan - 1)->startOfWeek(Carbon::MONDAY);

        // Mỗi ngày trong tuần
        $daysInWeek = collect();
        for ($i = 0; $i < 7; $i++) {
            $daysInWeek->push($startOfWeek->copy()->addDays($i));
        }

    // Dữ liệu dòng máy
    foreach ($request->entries as $entry) {
        foreach ($daysInWeek as $day) {
            DB::table('lichvanhanh')->insert([
                'NgayVanHanh' => $day->format('Y-m-d'),
                'MaMay' => $entry['MaMay'],
                'MaNhanVien' => $entry['MaNhanVien'],
                'CaLamViec' => $entry['CaLamViec'],
                'MoTa' => $entry['MoTa'],
            ]);
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
