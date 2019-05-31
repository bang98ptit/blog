<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slide;
use Illuminate\Support\Facades\Auth;

class SlideController extends Controller
{
    //
    public function getDanhSach()
    {
        $user=Auth::user();
    	$slide=Slide::all();
    	return view('admin.slide.danhsach',['slide'=>$slide,'userlogin'=>$user]);
    }
    public function getThem()
    {
        $user=Auth::user();
        return view('admin.slide.them',['userlogin'=>$user]);
    }
    public function postThem(Request $request)
    {
        
        $this->validate($request,
            [
            
            'Ten'=>'required',
            'NoiDung'=>'required'

        ],
        [
            'Ten.required'=>'ban chua nhap ten',
            'NoiDung.required'=>'ban chua nhap noi dung'
            
        ]);
        $sd=new Slide;
       $sd->Ten=$request->Ten;
       $sd->NoiDung=$request->NoiDung;
       if($request->has('link'))
        $sd->link=$request->link;
        if($request->hasFile('Hinh'))
        {
                $file = $request->file('Hinh');
                $duoi=$file->getClientOriginalExtension();
                if($duoi != 'jpg'&& $duoi!='png' )
                {
                    return redirect('admin/slide/them')->with('thongbao','chi chon file co duoi jpg,png');
                }
                $name = $file->getClientOriginalName();
                $hinh = str_random(4)."_".$name;
                While(file_exists("upload/slide/".$hinh))
                {
                        $hinh = str_random(4)."_".$name;
                }
                $file->move("upload/slide",$hinh); //lua hinh vao file uoload
                $sd->Hinh=$hinh;
        }
        else{
            $sd->Hinh="";
        }

        $sd->save();
        return redirect('admin/slide/them')->with('thongbao','them thanh cong');
    }

    public function getSua($id)
    {
        $user=Auth::user();
        $slide=Slide::find($id);
        return view('admin.slide.sua',['slide'=>$slide,'userlogin'=>$user]);

    }
    public function postSua(Request $request,$id)
    {       
       $this->validate($request,
            [
            
            'Ten'=>'required',
            'NoiDung'=>'required'

        ],
        [
            'Ten.required'=>'ban chua nhap ten',
            'NoiDung.required'=>'ban chua nhap noi dung'
            
        ]);
    $sd=Slide::find($id);
       $sd->Ten=$request->Ten;
       $sd->NoiDung=$request->NoiDung;
       if($request->has('link'))
        $sd->link=$request->link;
        if($request->hasFile('Hinh'))
        {
                $file = $request->file('Hinh');
                $duoi=$file->getClientOriginalExtension();
                if($duoi != 'jpg'&& $duoi!='png' )
                {
                    return redirect('admin/slide/sua')->with('thongbao','chi chon file co duoi jpg,png');
                }
                $name = $file->getClientOriginalName();
                $hinh = str_random(4)."_".$name;
                While(file_exists("upload/slide/".$hinh))
                {
                        $hinh = str_random(4)."_".$name;
                }
                
                $file->move("upload/slide",$hinh); //lua hinh vao file uoload
                $sd->Hinh=$hinh;
        }
        

        $sd->save();
        return redirect('admin/slide/sua/'.$id)->with('thongbao','sua thanh cong');

    }
    public function getXoa($id)
    {
       $sl=Slide::find($id);
       $sl->delete();
        return redirect('admin/slide/danhsach')->with('thongbao','ban da xoa thanh cong');
    }
}
