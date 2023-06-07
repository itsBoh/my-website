<!DOCTYPE html>
<html style="font-size: 16px;" lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <title>Registrasi</title>
  <link rel="stylesheet" href="{{ asset('css/initial.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('css/Registrasi.css') }}" media="screen">
  <script class="u-script" type="text/javascript" src="{{ asset('/jquery-1.9.1.min.js') }}" defer=""></script>
  <script class="u-script" type="text/javascript" src="{{ asset('/initial.js') }}" defer=""></script>
  <meta name="referrer" content="origin">
  <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
  <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": ""
    }
  </script>
  <meta name="theme-color" content="#0066ff">
  <meta property="og:title" content="Registrasi">
  <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/">
</head>

<body class="u-body u-hide-footer u-hide-header u-xl-mode" data-style="blank" data-posts="">
  <section class="u-align-center u-clearfix u-grey-80 u-block-104c-129" custom-posts-hash="T" data-section-properties="{&quot;margin&quot;:&quot;both&quot;,&quot;stretch&quot;:true}" data-id="104c" data-style="login-form-1" id="sec-07dc">
    <div class="u-clearfix u-sheet u-valign-middle-sm u-valign-middle-xs u-block-104c-2">
      <div class="u-align-center u-container-style u-expanded-width-sm u-expanded-width-xs u-group u-radius-50 u-shape-round u-uploaded-video u-video u-block-104c-46">
        <div class="u-absolute-hcenter u-background-video u-expanded u-shading" style="filter: brightness(0.65)">
          <div class="embed-responsive u-block-104c-130"><video class="embed-responsive-item" data-autoplay="1" loop="" muted="1" __idm_id__="3850268">
              <source src="{{ asset('/images/regis.mp4') }}" type="video/mp4">
              <p>Your browser does not support HTML5 video.</p>
            </video></div>
        </div>
        <div class="u-container-layout u-valign-bottom u-block-104c-47">
          <div class="u-shape u-block-104c-121"></div>
          <div class="u-carousel u-carousel-duration-250 u-carousel-fade u-form u-block-104c-64" data-interval="0" data-u-ride="false">
            <form action="{{route('register-user')}}" method="POST" class="u-clearfix u-form-spacing-10 u-form-vertical u-inner-form" source="email" data-services="a8f61cfbd31b9af48561caab1a3d675a" name="form" style="padding: 10px;">
              @if(Session::has('success'))
              <div class="alert alert-success">
                {{Session::get('success')}}
              </div>
              @endif
              @if(Session::has('fail'))
              <div class="alert alert-danger">
                {{Session::get('fail')}}
              </div>
              @endif
              @csrf
              <input type="hidden" name="CUST_ID" value="1">
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Username</span>
                <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" name="CUST_USERNAME" required>
                <span class="text-danger">@error('username') {{$message}} @enderror</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Full name</span>
                <input type="text" class="form-control" aria-label="Name" aria-describedby="basic-addon1" name="CUST_NAME" required>
                <span class="text-danger">@error('name') {{$message}} @enderror</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Email</span>
                <input type="email" class="form-control" aria-label="Email" aria-describedby="basic-addon1" name="CUST_EMAIL" required>
                <span class="text-danger">@error('email') {{$message}} @enderror</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Password</span>
                <input type="password" class="form-control" aria-label="Email" aria-describedby="basic-addon1" name="CUST_PASSWORD" required>
                <span class="text-danger">@error('email') {{$message}} @enderror</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Address </span>
                <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" name="CUST_ADDRESS" required>
                <span class="text-danger">@error('address') {{$message}} @enderror</span>
              </div>
              <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">Phone </span>
                <input type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1" name="cust_phone" required>
                <span class="text-danger">@error('phone') {{$message}} @enderror</span>
              </div>
              <div class="input-group mb-3">
                <label class="input-group-text" for="gender">Gender</label>
                <select class="form-select" id="gender" name="CUST_GENDER" required>
                  <option selected>Choose...</option>
                  <option value="M">Male</option>
                  <option value="F">Female</option>
                </select>
                <span class="text-danger">@error('gender') {{$message}} @enderror</span>
              </div>
              <input type="submit" value="Sign Up" class="u-active-palette-1-light-3 u-align-center u-border-none u-btn u-btn-round u-button-style u-hover-palette-1-light-2 u-palette-5-dark-2 u-radius-50 u-text-active-palette-1-dark-1 u-text-hover-palette-1-dark-2 u-text-palette-1-light-3 u-block-104c-120">
            </form>
          </div><a href="{{ url('login') }}" class="u-active-palette-1-light-3 u-align-center u-border-none u-btn u-btn-round u-button-style u-hover-palette-1-light-2 u-palette-5-dark-2 u-radius-50 u-text-active-palette-1-dark-1 u-text-hover-palette-1-dark-2 u-text-palette-1-light-3 u-block-104c-120">Back
            to Login</a>
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
</body>

</html>