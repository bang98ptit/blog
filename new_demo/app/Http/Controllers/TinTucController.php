<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\LoaiTin;
use App\TinTuc;
use App\Comment;
use Illuminate\Support\Facades\Auth;

class TinTucController extends Controller
{
    //
    public function getDanhSach()
    {
        $user=Auth::user();
    	$tt=TinTuc::orderBy('id','DESC')->get();
    	return view('admin.tintuc.danhsach',['tintuc'=>$tt,'userlogin'=>$user]);
    }
    public function getThem()
    {
        $user=Auth::user();
    	$tl=TheLoai::all();
    	$lt=LoaiTin::all();
    	return view('admin.tintuc.them',['theloai'=>$tl],['loaitin'=>$lt,'userlogin'=>$user]);
    }
    public function postThem(Request $request)
    {
    	$this->validate($request,
    		[
    			'LoaiTin'=>'required',
    			'TieuDe'=>'required|min:3|max:100|unique:TinTuc,TieuDe',
    			'TomTat'=>'required', 
    			'NoiDung'=>'required'
    		],
    		[
    			'LoaiTin.required'=>'ban chua nhap loai tin',
    			'TieuDe.required'=>'ban chua nhap tieu de',
    			'TieuDe.min'=>'tieu de lon hon 3 ki tu ',
    			'TieuDe.unique'=>'tieu de da ton tai',
    			'TomTat.required'=>'chua nhap tom tat',
    			'NoiDung.required'=>'chua nhap noi dung'
    		]);
    	$tintuc = new TinTuc;
    	$tintuc->TieuDe=$request->TieuDe;
    	$tintuc->TieuDeKhongDau=changeTitle($request->TieuDe);
    	$tintuc->idLoaiTin=$request->LoaiTin;
    	$tintuc->TomTat=$request->TomTat;
    	$tintuc->NoiDung=$request->NoiDung;
    	$tintuc->SoLuotXem=0;
    	if($request->hasFile('Hinh'))
    	{
    			$file = $request->file('Hinh');
    			$duoi=$file->getClientOriginalExtension();
    			if($duoi != 'jpg'&& $duoi!='png' )
    			{
    				return redirect('admin/tintuc/them')->with('thongbao','chi chon file co duoi jpg,png');
    			}
    			$name = $file->getClientOriginalName();
    			$hinh = str_random(4)."_".$name;
    			While(file_exists("upload/tintuc/".$hinh))
    			{
    					$hinh = str_random(4)."_".$name;
    			}
    			$file->move("upload/tintuc",$hinh); //lua hinh vao file uoload
    			$tintuc->Hinh=$hinh;
    	}
    	else{
    		$tintuc->Hinh="";
    	}
    	$tintuc->save();
    	return redirect('admin/tintuc/them')->with('thongbao','them tin thanh cong');
    }
    public function getSua($id)
    {	$user=Auth::user();
    	
    	$theloai=TheLoai::all();
    	$loaitin=LoaiTin::all();
    	$tintuc=TinTuc::find($id);
    	return view('admin.tintuc.sua',['tintuc'=>$tintuc,'theloai'=>$theloai,'loaitin'=>$loaitin,'userlogin'=>$user]);

    	
    }
    public function getXoa($id)
    {
    	$tintuc =TinTuc::find($id);
    	$tintuc->delete();
    	return redirect('admin/tintuc/danhsach')->with('thongbao','xoa thanh cong');
    }
    	

}
