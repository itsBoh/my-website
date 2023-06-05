<!DOCTYPE html>
<html style="font-size: 16px;" lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <title>Login</title>
  <link rel="stylesheet" href="{{ asset('/css/initial.css') }}" media="screen">
  <link rel="stylesheet" href="{{ asset('/css/Login.css') }}" media="screen">
  <script class="u-script" type="text/javascript" src="{{ asset('/jquery-1.9.1.min.js') }}" defer=""></script>
  <script class="u-script" type="text/javascript" src="{{ asset('/initial.js') }}" defer=""></script>

  <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
  <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i">


  <script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "Organization",
      "name": ""
    }
  </script>
  <meta name="theme-color" content="#0066ff">
  <meta property="og:title" content="Login">
  <meta property="og:type" content="website">
  <meta data-intl-tel-input-cdn-path="intlTelInput/">
</head>

<body class="u-body u-hide-header u-xl-mode" data-style="blank" data-posts="">
  @if(session('error'))
    <div>{{ session('error') }}</div>
  @endif
  <section class="u-align-center u-clearfix u-block-22fd-65" custom-posts-hash="T" data-section-properties="{&quot;margin&quot;:&quot;both&quot;,&quot;stretch&quot;:true}" data-id="22fd" data-style="login-form-1" id="sec-07dc">

    <div class="u-clearfix u-sheet u-block-22fd-68">
      <div class="u-expanded-height u-uploaded-video u-video u-video-cover u-block-22fd-66">
        <div class="embed-responsive u-block-22fd-67"><video class="embed-responsive-item" data-autoplay="1" loop="" muted="1" __idm_id__="3850253">
            <source src="{{ asset('/images/login.mp4') }}" type="video/mp4">
            <p>Your browser does not support HTML5 video.</p>
          </video></div>
      </div>
      <div class="u-align-center u-container-style u-expanded-width-xs u-group u-radius-30 u-shape-round u-white u-block-22fd-46" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction="">
        <div class="u-container-layout u-valign-bottom-lg u-valign-bottom-md u-valign-bottom-sm u-block-22fd-47"><img class="u-expanded-width-md u-expanded-width-sm u-image u-image-contain u-image-default u-block-22fd-64" src="{{ asset('/images/icons/logo-01.png') }}" alt="" data-image-width="1663" data-image-height="213">
          <div class="u-form u-login-control u-block-22fd-49" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction="">
            <form method="POST" action="{{ route('login-user') }}" class="u-clearfix u-form-custom-backend u-form-spacing-20 u-form-vertical u-inner-form" source="custom" name="formLogin" style="padding: 30px;" data-services="" redirect="true">
              @csrf
              <div class="u-form-group u-form-name u-block-22fd-50">
                <label for="username" class="u-custom-font u-font-montserrat u-label u-block-22fd-51">Username
                  *</label>
                <input type="text" placeholder="Enter your Username" id="username" name="CUST_USERNAME" class="u-input u-input-rectangle u-block-22fd-52" required spellcheck="false">
              </div>
              <div class="u-form-group u-block-22fd-53">
                <label for="password" class="u-custom-font u-font-montserrat u-label u-block-22fd-54">Password
                  *</label>
                <input type="password" placeholder="Enter your Password" id="password" name="CUST_PASSWORD" class="u-input u-input-rectangle u-block-22fd-55" required>
              </div>
              <div class="u-form-checkbox u-form-group u-block-22fd-56">
                <input type="checkbox" id="remember" name="remember" value="On" class="u-field-input">
                <label for="remember" class="u-block-22fd-57 u-field-label">Remember me</label>
              </div>

              <div class="u-form-group u-form-submit u-block-22fd-58">
                <!-- <a class="u-active-palette-1-light-2 u-border-none u-btn u-btn-round u-btn-submit u-button-style u-custom-font u-font-montserrat u-hover-palette-1-light-1 u-palette-1-dark-2 u-radius-50 u-text-hover-palette-1-light-3 u-block-22fd-59" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction="">Login</a> -->
                <input type="submit" value="Login" class="u-active-palette-1-light-2 u-border-none u-btn u-btn-round u-btn-submit u-button-style u-custom-font u-font-montserrat u-hover-palette-1-light-1 u-palette-1-dark-2 u-radius-50 u-text-hover-palette-1-light-3 u-block-22fd-59" data-animation-name="" data-animation-duration="0" data-animation-delay="0" data-animation-direction="">
              </div>
              <input type="hidden" value="" name="recaptchaResponse">
              <input type="hidden" id="siteId" name="siteId" value="4851710">
              <input type="hidden" id="pageId" name="pageId" value="4853420">
            </form>
          </div><a href="{{ url('Forgot-Password') }}" class="u-border-active-palette-2-base u-border-hover-palette-1-base u-border-none u-btn u-button-style u-login-control u-login-forgot-password u-none u-text-grey-40 u-text-hover-palette-4-base u-block-22fd-60">Forgot
            password?</a><a href="{{ url('Registrasi') }}" class="u-border-active-palette-2-base u-border-hover-palette-1-base u-border-none u-btn u-button-style u-login-control u-login-create-account u-none u-text-grey-40 u-text-hover-palette-4-base u-block-22fd-61">Don't
            have an account?<br>Create your account</a>
        </div>
      </div>
    </div>
  </section>
</body>

</html>