<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use Illuminate\Support\Facades\Auth;

class TheLoaiController extends Controller
{
    //
    

    public function getDanhSach()
    {
        $user=Auth::user();
    	$theloai = TheLoai::all();
    	return view('admin.theloai.danhsach',['theloai'=>$theloai,'userlogin'=>$user]);

    }
    public function getThem()
    {
        $user=Auth::user();
        return view('admin.theloai.them',['userlogin'=>$user]);
    }
    public function postThem(Request $request)
    {
        $this->validate($request,
        [
                'Ten'=>'required|min:3|max:100|unique:TheLoai,Ten'
        ],
        
        [
                'Ten.required'=>'ban chua nhap ten the loai',
                'Ten.min'=>'hon 3 ki tu',
                'Ten.max'=>'it hon 100 ki tu'

        ]);
        $theloai = new TheLoai;
        $theloai->Ten=$request->Ten;
        $theloai->TenKhongDau= changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/them')->with('thong bao', 'them thanh cong');

    }

    public function getSua($id)
    {
        $user=Auth::user();
        $theloai= TheLoai::find($id);
        return view('admin.theloai.sua',['theloai'=>$theloai,'userlogin'=>$user]);


    }
    public function postSua(Request $request,$id)
    {       
        $theloai=TheLoai::find($id);
        $this->validate($request,
            [
                'Ten'=>'required|min:3|max:100|unique:TheLoai,Ten'
        ],
        [
                'Ten.required'=>'ban chua nhap ten ',
                'Ten.unique'=>'ten da ton tai',
                'Ten.min'=>'ten lon hon 3 ki tu',
                'Ten.max'=>'ten nho hon 100 ki tu'
        ]
        );
        $theloai->Ten=$request->Ten;
        $theloai->TenKhongDau= changeTitle($request->Ten);
        $theloai->save();
        return redirect('admin/theloai/sua/'.$id)->with('thongbao','sua thanh cong');

    }
    public function getXoa($id)
    {
        $theloai =TheLoai::find($id);
        $theloai->delete();
        return redirect('admin/theloai/danhsach')->with('thongbao','ban da xoa thanh cong');
    }
}
