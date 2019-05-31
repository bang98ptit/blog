@extends('admin.layout.index')
@section('content')
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">TinTuc
                            <small>Them</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                    <div class="col-lg-7" style="padding-bottom:120px">
                         @if(count($errors)>0)
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $err)
                            {{$err}} <br>
                            @endforeach
                        </div>
                        @endif
                        @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                        @endif
                        <form action="admin/tintuc/them" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label>The Loai</label>
                                <select class="form-control" name="TheLoai" id="TheLoai">
                                    @foreach($theloai as $tl)
                                    <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Loai Tin</label>
                                <select class="form-control" name="LoaiTin" id="LoaiTin">
                                    @foreach($loaitin as $lt)
                                    <option value="{{$lt->id}}">{{$lt->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tieu De</label>
                                <input class="form-control" name="TieuDe" placeholder="Please Enter Category Name" />
                            </div>
                            
                            <div class="form-group">
                                <label>Tom Tat</label>
                                <textarea id="demo" class="form-control ckeditor" rows="3" name="TomTat"></textarea>
                            </div>
                              <div class="form-group">
                                <label>Noi Dung</label>
                                <textarea id="demo" class="form-control ckeditor" rows="5" name="NoiDung"></textarea>
                            </div>
                            <div class="form-group">
                                 <label>Hinh Anh</label>
                                 <input type="file" name="Hinh" class="form-control">
                                
                            </div>

                            <div class="form-group">
                                <label>Noi Bat</label>
                                <label class="radio-inline">
                                    <input name="NoiBat" value="0" checked="" type="radio">Khong
                                </label>
                                <label class="radio-inline">
                                    <input name="NoiBat" value="1" type="radio">Co
                                </label>
                            </div>
                            <button type="submit" class="btn btn-default">Them</button>
                            <button type="reset" class="btn btn-default">Lam moi</button>
                        <form>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
@endsection    
@section('script')
    
<script>
    $(document).ready(function(){
        $("#TheLoai").change(function(){
            var idTheLoai=$(this).val();
            $.get("admin/ajax/loaitin/"+idTheLoai,function(data){
                $("#LoaiTin").html(data);
            });
        });
    });
        
    
</script>










@endsection  