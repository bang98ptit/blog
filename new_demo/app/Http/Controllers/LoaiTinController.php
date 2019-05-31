<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoaiTin;
use App\TheLoai;
use Illuminate\Support\Facades\Auth;

class LoaiTinController extends Controller
{
    //
    public function getDanhSach()
    {
          $user=Auth::user();
    	$lt = LoaiTin::all();
    	return view('admin.loaitin.danhsach',['loaitin'=>$lt,'userlogin'=>$user]);

    }
    public function getThem()
    {
          $user=Auth::user();
        $tl = TheLoai::all();
        return view('admin.loaitin.them',['theloai'=>$tl,'userlogin'=>$user]);
    }
    public function postThem(Request $request)
    {
        
        $this->validate($request,
            [
            'Ten'=>'required|unique:LoaiTin,Ten|min:1|max:100',
            'TheLoai'=>'required'

        ],
        [
            'Ten.required'=>'ban chua nhap ten',
            'Ten.unique'=>'ten trung',
            'Ten.min'=>'ten lon hon 1 ki tu',
            'Ten.max'=>'ten nho hon 100 ki tu',
            'TheLoai.required'=>'ban chua chon the loai'
        ]);
        $lt= new LoaiTin;
        $lt->Ten=$request->Ten;
        $lt->TenKhongDau=changeTitle($request->Ten);
        $lt->idTheLoai=$request->TheLoai;
        $lt->save();
        return redirect('admin/loaitin/them')->with('thongbao','them thanh cong');
    }

    public function getSua($id)
    {
          $user=Auth::user();
        $theloai=TheLoai::all();
        $loaitin=LoaiTin::find($id);
         return view('admin.loaitin.sua',['loaitin'=>$loaitin,'theloai'=>$theloai,'userlogin'=>$user]);


    }
    public function postSua(Request $request,$id)
    {       
        $this->validate($request,
            [
            'Ten'=>'required|unique:LoaiTin,Ten|min:1|max:100',
            'TheLoai'=>'required'

        ],
        [
            'Ten.required'=>'ban chua nhap ten',
            'Ten.unique'=>'ten trung',
            'Ten.min'=>'ten lon hon 1 ki tu',
            'Ten.max'=>'ten nho hon 100 ki tu',
            'TheLoai.required'=>'ban chua chon the loai'
        ]);
        $lt=LoaiTin::find($id);
        $lt->Ten=$request->Ten;
        $lt->TenKhongDau=changeTitle($request->Ten);
        $lt->idTheLoai=$request->TheLoai;
        $lt->save();
        return redirect('admin/loaitin/sua/'.$id)->with('thongbao','sua thanh cong');

    }
    public function getXoa($id)
    {
        $loaitin =LoaiTin::find($id);
        $loaitin->delete();
        return redirect('admin/loaitin/danhsach')->with('thongbao','ban da xoa thanh cong');
    }
}
