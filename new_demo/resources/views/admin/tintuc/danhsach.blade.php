@extends('admin.layout.index')
@section('content')
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">TinTuc
                            <small>Danh Sach</small>
                        </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                     @if(session('thongbao'))
                        <div class="alert alert-success">
                            {{session('thongbao')}}
                        </div>
                        @endif
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr align="center">
                                <th>ID</th>
                                <th>Tieu De</th>
                                <th>Tom Tat</th>
                                <th>Loai Tin</th>
                                <th>The Loai</th>
                               
                                <th>Xem</th>
                                <th>Noi Bat</th>
                                <th>Delete</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($tintuc as $tt)
                            <tr class="odd gradeX" align="center">
                                <td>{{$tt->id}}
                                    
                                </td>
                                <td><p>{{$tt->TieuDe}}<p>
                                    <img width="100px" src="upload/tintuc/{{$tt->Hinh}}"
                                </td>
                                <td>{{$tt->TomTat}}</td>
                                <td>{{$tt->loaitin->Ten}}</td>
                                <td>{{$tt->loaitin->theloai->Ten}}</td>
                                <td>{{$tt->SoLuotXem}}</td>
                                <td>
                                    @if($tt->NoiBat==0)
                                    {{'khong'}}
                                    @else
                                    {{'co'}}
                                    @endif
                                </td>
                                

                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="admin/tintuc/xoa/{{$tt->id}}">xoa</a></td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="admin/tintuc/sua/{{$tt->id}}">sua</a></td>
                            </tr>
                         @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

@endsection