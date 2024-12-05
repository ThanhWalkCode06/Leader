<?php

namespace App\Http\Controllers\Admins;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        $listSanPham = DB::table('users')->whereNull('deleted_at')->orderBy('id','DESC')->paginate(5);
        return view('admins.Accounts.index',compact('listSanPham'));
    }

    public function search(Request $request){
        $search = DB::table('users')
        ->where('name','like','%'.$request->key.'%')
        ->orwhere('email','like','%'.$request->key.'%')
        ->orderBy('id','DESC')->paginate(5);
        return view('admins.accounts.index',compact('search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['created_at'] = now();
        $user = User::query()->create($data);
        if($user){
            return redirect()->route('users.index')->with('success','Thêm account admin thành công');
        }else{
            return redirect()->route('users.index')->with('error','Thêm account admin thất bại');
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $itemId = DB::table('users')->find($id);
        return view('admins.accounts.edit',compact('itemId'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateUserRequest $request, string $id)
    // {
    //     $itemId = DB::table('nhan_viens')->find($id);
    //     $data = $request->validated();
    //     $flag = DB::table('nhan_viens')->where('id',$id)->update($data);
    //     if($flag){
    //         return redirect()->route('accounts.index')->with('success','Sửa nhân viên thành công');
    //     } else{
    //         return redirect()->route('accounts.index')->with('error','Sửa nhân viên thất bại');
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $itemId = User::find($id);
        DB::table('users')
        ->where('id', $id)
        ->update(['deleted_at' => Carbon::now()]);
        return redirect()->route('users.index')->with('success','Xóa nhân viên thành công');
    }
}
