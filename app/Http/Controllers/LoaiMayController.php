<?php

namespace App\Http\Controllers;
use App\Events\eventUpdateTable;
use Illuminate\Http\Request;
use App\Models\LoaiMay;
class LoaiMayController extends Controller
{
    public function index(Request $request)
    {
        $query = LoaiMay::query()->withCount('mays');

        $filters = [
            'TenLoai' => 'like',
            'MoTa' => '=',
        ];

        foreach ($filters as $field => $operator) {
            if ($request->filled($field)) {
                $value = $operator === 'like' ? '%' . $request->$field . '%' : $request->$field;
                $query->where($field, $operator, $value);
            }
        }

        $loaimays = $query->paginate(10);

        return view('vMay.loaiMay', compact('loaimays'));
    }
    public function create()
    {
        return view('vMay.createLoaiMay');
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'TenLoai' => 'required|string|max:255|unique:loaimay,TenLoai',
                'MoTa' => 'required|string|max:10|unique:loaimay,MoTa',
            ], [
                'TenLoai.unique' => 'Tên loại máy đã tồn tại trong hệ thống.',
                'MoTa.unique' => 'Tên viết tắt đã tồn tại trong hệ thống.',
            ]);

            LoaiMay::create([
                'TenLoai' => $request->TenLoai,
                'MoTa' => $request->MoTa,
            ]);

            return redirect()->route('loaimay.index')->with('success', 'Đã thêm loại máy thành công.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->with('error', $e->validator->errors()->first());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Thêm mới không thành công, vui lòng kiểm tra lại.');
        }
    }
    public function destroy($id)
    {
        try {
            $loaimay = LoaiMay::findOrFail($id);
            $loaimay->delete();

            return redirect()->back()->with('success', 'Xóa loại máy thành công.');
        } catch (\Illuminate\Database\QueryException $e) {

            return redirect()->back()->with('error', 'Không thể xóa loại máy vì đang được sử dụng.');
        }
    }

    public function createLoaiMayfromMay()
    {
        return view('vMay.createLoaiMayfromMay');
    }
    public function storeLoaiMayfromMay(Request $request)
    {
        try {
            $request->validate([
                'TenLoai' => 'required|string|max:255|unique:loaimay,TenLoai',
                'MoTa' => 'required|string|max:10|unique:loaimay,MoTa',
            ], [
                'TenLoai.unique' => 'Tên loại máy đã tồn tại trong hệ thống.',
                'MoTa.unique' => 'Tên viết tắt đã tồn tại trong hệ thống.',
            ]);
            LoaiMay::create([
                'TenLoai' => $request->TenLoai,
                'MoTa' => $request->MoTa,
            ]);

            return redirect()->route('may.add')->with('success', 'Thêm loại máy thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withInput()->with('error', $e->validator->errors()->first());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Thêm máy mới không thành công, vui lòng kiểm tra lại.');
        }
    }
}
