<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth; // thu vien su dung lop dang nhap

class UserController extends Controller
{
  
    public function getDanhSach()
    {
          $u=Auth::user();
    	$user=User::all();
    	return view('admin.user.danhsach',['user'=>$user,'userlogin'=>$u]);
    }
    public function getThem()
    {
    	 $u=Auth::user();
    	return view('admin.user.them',['userlogin'=>$u]);
    }
    public  function postThem(Request $request)
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
    	$u->quyen=$request->quyen;
    	$u->save();
    	return redirect('admin/user/them')->with('thongbao','them thanh cong');

    }
    public function getSua($id)
    {
         $u=Auth::user();
    	$user = User::find($id);
    	return view('admin.user.sua',['user'=>$user,'userlogin'=>$u]);

    }
    public function postSua(Request $request,$id)
    {
    	$this->validate($request,
    		[
    			'name'=>'required|min:3',
    			
    			
    		],
    		[
    			'name.required'=>'ban chua nhap ten nguoi dung',
    			'name.min'=>'ten nguoi dung lon hon 3 ki tu',
    			
    		]);
    	$u = User::find($id);
    	$u->name=$request->name;
    	$u->quyen=$request->quyen;

			if($request->changePassword == "on")
			{
				$this->validate($request,
    		[
    			
    			'password'=>'required|min:3|max:32',
    			'passwordagain'=>'required|same:password'
    		],
    		[
    			
    			'password.required'=>'ban chua nhap password',
    			'password.min'=>'may khau it nhat 3 ki tu',
    			'password.max'=>'mat khau toi da 32 ki tu',
    			'passwordagain.required'=>'ban chua nhap lai mat khau',
    			'passwordagain.same'=>'mat khau nhap lai khong trung khop'
    		]);
				    	$u->password=bcrypt($request->password);
			}

    	$u->save();
    	return redirect('admin/user/sua/'.$id)->with('thongbao','sua thanh cong');
    }
    public function getXoa($id)
    {
    	$u=User::find($id);
    	$u->delete();
    	return redirect('admin/user/danhsach')->with('thongbao','xoa thanh cong');
    }
    public function getdangnhapAdmin()
    {
        return view('admin.login');
    }
    public function postdangnhapAdmin(Request $request)
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
            return redirect('admin/theloai/danhsach');
        }
        else
        {
            return redirect('admin/dangnhap')->with('thongbao','dang nhap ko thanh cong');
        }
    }
    public function getdangxuatAdmin()
    {
        Auth::logout();
        return redirect('admin/dangnhap');
    }
}
