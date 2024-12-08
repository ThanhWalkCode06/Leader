<?php

namespace App\Http\Controllers\Admins;

use Carbon\Carbon;
use App\Models\NhanVien;
use App\Models\PhongBan;
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
        $listSanPham = NhanVien::with('phongBan')->whereNull('deleted_at')
        ->orderByDesc('id')
        ->paginate(5);
        // dd($listSanPham);
        return view('admins.nhanviens.index',compact('listSanPham'));
    }

    public function search(Request $request){
        $search = NhanVien::with('phongBan')
        ->where('ten_nhan_vien','like','%'.$request->key.'%')
        ->orwhere('ma_nhan_vien','like','%'.$request->key.'%')
        ->orWhereHas('phongBan', function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->key . '%'); // Tìm theo tên phòng ban
        })
        ->orderBy('id','DESC')->paginate(5);
        return view('admins.nhanviens.index',compact('search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $phong_bans = PhongBan::pluck('name','id')->all();
        return view('admins.nhanviens.create',compact('phong_bans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNhanVienRequest $request)
    {
        $data = $request->validated();
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
    public function edit(Nhanvien $nhanvien)
    {
        $nhanvien->load('phongban');
        $phong_bans = PhongBan::pluck('name','id')->all();
        // dd($nhanvien);
        return view('admins.nhanviens.edit',compact('nhanvien','phong_bans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNhanVienRequest $request, string $id)
    {
        $itemId = DB::table('nhan_viens')->find($id);
        $data = $request->validated();
        // dd($data);
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
