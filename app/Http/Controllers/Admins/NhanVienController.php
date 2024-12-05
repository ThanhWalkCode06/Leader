<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreNhanVienRequest;
use App\Http\Requests\UpdateNhanVienRequest;

class NhanVienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listSanPham = DB::table('nhan_viens')->whereNull('deleted_at')->orderBy('id','DESC')->paginate(5);
        return view('admins.nhanviens.index',compact('listSanPham'));
    }

    public function search(Request $request){
        $search = DB::table('nhan_viens')
        ->where('ten_nhan_vien','like','%'.$request->key.'%')
        ->orwhere('ma_nhan_vien','like','%'.$request->key.'%')
        ->orderBy('id','DESC')->paginate(5);
        return view('admins.nhanviens.index',compact('search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.nhanviens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNhanVienRequest $request)
    {
        $data = $request->validated();
        // dd($data);
        if(file_exists($request->hinh_anh)){
            $file_path = $request->hinh_anh->store('uploads/nhanvien','public');
        }
        $data['hinh_anh'] = $file_path;
        DB::table('nhan_viens')->insert($data);
        return redirect()->route('nhanviens.index')->with('success','Thêm nhân viên thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(NhanVien $nhanVien)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $itemId = DB::table('nhan_viens')->find($id);
        return view('admins.nhanviens.edit',compact('itemId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNhanVienRequest $request, string $id)
    {
        $itemId = DB::table('nhan_viens')->find($id);
        $data = $request->validated();
        $file_path = $itemId->hinh_anh;
        // dd(file_exists($request->hinh_anh));

        if(file_exists($request->hinh_anh)){
            Storage::disk('public')->delete($file_path);
            $file_path = $request->hinh_anh->store('uploads/nhanvien','public');
        }
        $data['hinh_anh'] = $file_path;
        DB::table('nhan_viens')->where('id',$id)->update($data);
        return redirect()->route('nhanviens.index')->with('success','Sửa nhân viên thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $itemId = DB::table('nhan_viens')->find($id);
        $itemId = NhanVien::find($id);
        $deleteSP = $itemId->delete();
        if(Storage::disk('public')->exists($itemId->hinh_anh)){
            Storage::disk('public')->delete($itemId->hinh_anh);
        }
        // DB::table('nhan_viens')
        // ->where('id', $id)
        // ->update(['deleted_at' => Carbon::now()]);
        return redirect()->route('nhanviens.index')->with('success','Xóa nhân viên thành công');
    }
}
