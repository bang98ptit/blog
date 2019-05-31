<!-- Navigation -->
   
    <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
       
      <div class="collapse navbar-collapse" id="navbarResponsive">

         <ul class="nav navbar-nav">
                    <li>
                       <a  href="trangchu">Home</a>
                    </li>
                   <li>
                     
                     <a href="pages/vietblog">Post</a>
                   </li>
                    <li>
                        <a href="lienhe">Contact</a>
                    </li>
                </ul>

                <form action="timkiem" method="post" class="navbar-form navbar-left" role="search">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                      <input type="text" name="tukhoa" class="form-control" placeholder="Search">
                    </div>
                    <button type="submit" class="btn btn-default">Search</button>
                </form>

                <ul class="nav navbar-nav pull-right">
                    <li>
                          <a href="">Vietnam</a>
                    </li>
                    <li>
                          <a href="">English</a>
                    </li>
                    @if(!isset($nguoidung))
                        <li>
                            <a href="dangky">Register</a>
                        </li>
                        <li>
                            <a href="dangnhap">Login</a>
                        </li>
                    @else
                        <li>
                            <a href="nguoidung">
                                <span class ="glyphicon glyphicon-user"></span>
                                {{$nguoidung->name}}
                            </a>
                        </li>

                        <li>
                            <a href="dangxuat">Logout</a>
                        </li>
                    @endif
                    
                </ul>
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <header class="masthead" style="background-image: url('newTheme/img/home-bg.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>NEW BLOG</h1>
            <span class="subheading">Make</span>
          </div>
        </div>
      </div>
    </div>
  </header>
