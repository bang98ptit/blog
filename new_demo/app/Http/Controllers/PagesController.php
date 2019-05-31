<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TheLoai;
use App\Slide;
use App\LoaiTin;
use App\TinTuc;
use App\User;
use Illuminate\Support\Facades\Auth;
class PagesController extends Controller
{
    //
    function __construct()
    {
    	$theloai=TheLoai::all();
        $slide=Slide::all();
    	view()->share('theloai',$theloai);
        view()->share('slide',$slide);

        
    }
    function trangchu()
    {   
        $user=Auth::user();
    	
    	return view('pages.trangchu',['nguoidung'=>$user]);
    }
    function lienhe()
    {
        $user=Auth::user();
    	
    	return view('pages.lienhe',['nguoidung'=>$user]);
    }
    function contact()
    {
        $user = Auth::user();
        return view('pages.contact',['nguoidung'=>$user]);
    }
    function loaitin($id)   
    {   
         $user=Auth::user();
        $loaitin =LoaiTin::find($id);
        $tintuc=TinTuc::where('idLoaiTin',$id)->paginate(5);
        return view('pages.loaitin',['loaitin'=>$loaitin,'nguoidung'=>$user,'tintuc'=>$tintuc]);
    }
    function tintuc($id)
    {
         $user=Auth::user();
        $tintuc =TinTuc::find($id);
        $tinnoibat=TinTuc::where('NoiBat',1)->take(4)->get();
        $tinlienquan= TinTuc::where('idLoaiTin',$tintuc->idLoaiTin)->take(4)->get();
        return view('pages.tintuc',['tintuc'=>$tintuc,'tinnoibat'=>$tinnoibat,'tinlienquan'=>$tinlienquan,'nguoidung'=>$user]);
    }
    function getDangnhap()
    {
        return view('pages.dangnhap');
    }
    function postDangnhap(Request $request)
    {
        $this->validate($request,
            [
                'email'=>'required',
                'password'=>'required|min:3|max:32',
            ],
            [
                'email.required'=>'ban chua nhap email',
                'password.required'=>'ban chua ngap password',
                'password.min'=>'pass ko nho hon 3 ki tu',
                'password.max'=>'pass ko lon hon 32 ki tu'
            ]);
         if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            return redirect('trangchu');
        }
        else
        {
            return redirect('dangnhap');
        }
    }
    function  dangxuat()
    {
        Auth::logout();
        return redirect('trangchu');
    }
    function getNguoidung()
    {
        $user=Auth::user();
       
        return view('pages.nguoidung',['nguoidung'=>$user]);
    }
    function postNguoidung(Request $request)
    {
            $this->validate($request,
            [
                'name'=>'required|min:3',
                
                
            ],
            [
                'name.required'=>'ban chua nhap ten nguoi dung',
                'name.min'=>'ten nguoi dung lon hon 3 ki tu',
                
            ]);
        $u = Auth::user();
        $u->name=$request->name;
       

            if($request->changePassword == "on")
            {
                $this->validate($request,
            [
                
                'password'=>'required|min:3|max:32',
                'passwordAgain'=>'required|same:password'
            ],
            [
                
                'password.required'=>'ban chua nhap password',
                'password.min'=>'may khau it nhat 3 ki tu',
                'password.max'=>'mat khau toi da 32 ki tu',
                'passwordAgain.required'=>'ban chua nhap lai mat khau',
                'passwordAgain.same'=>'mat khau nhap lai khong trung khop'
            ]);
                        $u->password=bcrypt($request->password);
            }

        $u->save();
        return redirect('nguoidung')->with('thongbao','sua thanh cong');
    }
    function getDangky()
    {
         
            return view('pages.dangky');
    }
    function postDangky(Request $request)
    {
        $this->validate($request,
            [
                'name'=>'required|min:3',
                'email'=>'required|email|unique:users,email', 
                'password'=>'required|min:3|max:32',
                'passwordagain'=>'required|same:password'
            ],
            [
                'name.required'=>'ban chua nhap ten nguoi dung',
                'name.min'=>'ten nguoi dung lon hon 3 ki tu',
                'email.required'=>'ban chua nhap email',
                'email.email'=>'ban chua nhap dung dinh dang email',
                'email.unique'=>'email da ton tai',
                'password.required'=>'ban chua nhap password',
                'password.min'=>'may khau it nhat 3 ki tu',
                'password.max'=>'mat khau toi da 32 ki tu',
                'passwordagain.required'=>'ban chua nhap lai mat khau',
                'passwordagain.same'=>'mat khau nhap lai khong trung khop'
            ]);
        $u = new User;
        $u->name=$request->name;
        $u->email=$request->email;
        $u->password=bcrypt($request->password);
        $u->quyen=0;
        $u->save();
        return redirect('dangky')->with('thongbao','dky thanh cong');

    }
    function timkiem(Request $request)
    {
        $user=Auth::user();

        $tukhoa= $request->tukhoa;
        $tintuc= TinTuc::where('TieuDe','like',"%$tukhoa%")->orWhere('TomTat','like',"%$tukhoa%")->orWhere('NoiDung','like',"%$tukhoa%")->take(30)->paginate(5);
        return view('pages.timkiem',['tintuc'=>$tintuc,'tukhoa'=>$tukhoa,'nguoidung'=>$user]);
    }
    public function getVietblog()
    {
        $user=Auth::user();
        $tl=TheLoai::all();
        $lt=LoaiTin::all();
        return view('pages.vietblog',['theloai'=>$tl],['loaitin'=>$lt,'nguoidung'=>$user]);
    }
    public function postVietblog(Request $request)
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
                    return redirect('pages/vietblog')->with('thongbao','chi chon file co duoi jpg,png');
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
        return redirect('pages/vietblog')->with('thongbao','them tin thanh cong');
    }
}
