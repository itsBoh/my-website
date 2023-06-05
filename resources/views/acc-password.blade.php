<!DOCTYPE html>
<html lang="en">

<head>
	<title>Password</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="{{ asset('/images/icons/favicon.png') }}" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/fonts/iconic/css/material-design-iconic-font.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/fonts/linearicons-v1.0.0/icon-font.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/animate/animate.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/css-hamburgers/hamburgers.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/animsition/css/animsition.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/select2/select2.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/main.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('/css/account.css') }}">
	<!--===============================================================================================-->
</head>

<body class="animsition">

	<!-- Header -->
	<header class="header-v4">
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						Gratis ongkir dengan minimum pembelanjaan Rp 500.000
					</div>
					@if(session('customer'))
					<div class="right-top-bar flex-w h-full">
						<a href="{{ route('account-profile') }}" class="flex-c-m trans-04 p-lr-25">
							My Account
						</a>
						<a href="{{ url('logout') }}" class="flex-c-m trans-04 p-lr-25">
							Log Out
						</a>
					</div>
					@else
					<a href="{{ url('login') }}" class="flex-c-m trans-04 p-lr-25">
						Log In
					</a>
					@endif
				</div>
			</div>

			<div class="wrap-menu-desktop how-shadow1">
				<nav class="limiter-menu-desktop container">

					<!-- Logo desktop -->
					<a href="{{ url('') }}" class="logo">
						<img src="{{ asset('/images/icons/logo-01.png') }}" alt="IMG-LOGO">
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="{{ url('') }}">Home</a>
							</li>

							<li>
								<a href="{{ url('products') }}">Shop</a>
							</li>

							<li>
								<a href="{{ url('cart') }}">Cart</a>
							</li>

							<li>
								<a href="{{ url('about') }}">About</a>
							</li>

							<li>
								<a href="{{ url('contact') }}">Contact</a>
							</li>
						</ul>
					</div>

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<!-- <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div> -->

						<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="{{ count($results)}}">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<div class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-wishlist" data-notify="{{ count($wishlists) }}" id="wishlist-btn">
							<i class="zmdi zmdi-favorite-outline"></i>
						</div>
					</div>
				</nav>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap-header-mobile">
			<!-- Logo moblie -->
			<div class="logo-mobile">
				<a href="{{ url('index') }}"><img src="{{ asset('/images/icons/logo-01.png') }}" alt="IMG-LOGO"></a>
			</div>

			<!-- Icon header -->
			<div class="wrap-icon-header flex-w flex-r-m m-r-15">
				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
					<i class="zmdi zmdi-search"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="2">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-wishlist" data-notify="0">
					<i class="zmdi zmdi-favorite-outline"></i>
				</div>
			</div>

			<!-- Button show menu -->
			<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
			</div>
		</div>


		<!-- Menu Mobile -->
		<div class="menu-mobile">
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar">
						Gratis ongkir dengan minimum pembelanjaan Rp 500.000
					</div>
				</li>

				<li>
					<div class="right-top-bar flex-w h-full">
						@if(session('customer'))
						<a href="{{ url('account-profile') }}" class="flex-c-m trans-04 p-lr-25">
							My Account
						</a>
						<a href="{{ url('logout') }}" class="flex-c-m trans-04 p-lr-25">
							Log Out
						</a>
						@else
						<a href="{{ url('login') }}" class="flex-c-m trans-04 p-lr-25">
							Log In
						</a>
						@endif
					</div>
				</li>
			</ul>
			<ul class="main-menu-m">
				<li>
					<a href="{{ url('') }}">Home</a>
				</li>

				<li>
					<a href="{{ url('products') }}">Shop</a>
				</li>

				<li>
					<a href="{{ url('cart') }}">Cart</a>
				</li>

				<li>
					<a href="{{ url('about') }}">About</a>
				</li>

				<li>
					<a href="{{ url('contact') }}">Contact</a>
				</li>
			</ul>
		</div>

		<!-- Modal Search -->
		<!-- <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
			<div class="container-search-header">
				<button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
					<img src="{{ asset('/images/icons/icon-close2.png') }}" alt="CLOSE">
				</button>

				<form class="wrap-search-header flex-w p-l-15">
					<button class="flex-c-m trans-04">
						<i class="zmdi zmdi-search"></i>
					</button>
					<input class="plh3" type="text" name="search" placeholder="Search...">
				</form>
			</div>
		</div> -->
	</header>

	<!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					@foreach($results as $result)
					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<!-- <img src="{{ asset('/images/item-cart-01.jpg') }}" alt="IMG"> -->
							@php
							$filename = '/images/product/' . $result->PROD_ID . ' ' . $result->PROD_NAME . '/' . $result->PROD_ID . '_1';
							$imgsrc = asset($filename . '.png');

							if (!file_exists(public_path($filename . '.png'))) {
							if (!file_exists(public_path($filename . '.jpg'))) {
							$imgsrc = asset('/images/unknown.jpg');
							} else {
							$imgsrc = asset($filename . '.jpg');
							}
							}
							@endphp
							<img src="{{ $imgsrc }}" alt="IMG">


						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="{{ url('#') }}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								{{ $result->PROD_NAME }}
							</a>

							<span class="header-cart-item-info">

								{{$result->CART_QTY}} x Rp {{ number_format($result->PROD_PRICE, 0, ',', '.') }}
							</span>
						</div>
					</li>
					@endforeach
					<!-- <li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="{{ asset('/images/item-cart-02.jpg') }}" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="{{ url('#') }}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								Converse All Star
							</a>

							<span class="header-cart-item-info">
								1 x Rp 390.000
							</span>
						</div>
					</li>

					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="{{ asset('/images/item-cart-03.jpg') }}" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="{{ url('#') }}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								Nixon Porter Leather
							</a>

							<span class="header-cart-item-info">
								1 x Rp 170.000
							</span>
						</div>
					</li> -->
				</ul>

				<div class="w-full">
					<div class="header-cart-total w-full p-tb-40">
						Total: Rp {{ number_format($total[0]->Price, 0, ',', '.') }}
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="{{ url('shoping-cart') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						<a href="{{ url('shoping-cart') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Check Out
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--- Wishlist Sidebar-->
	<div class="wrap-header-wishlist js-panel-wishlist">
		<div class="s-full js-hide-wishlist"></div>

		<div class="header-wishlist flex-col-l p-l-65 p-r-25">
			<div class="header-wishlist-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Wishlist
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-wishlist">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>
			<div class="header-wishlist-content flex-w js-pscroll">
				<ul class="header-wishlist-wrapitem w-full">
					@foreach($wishlists as $wish)
					<form action="{{ route('product-wishlist') }}" method="post">
						<li class="header-wishlist-item flex-w flex-t m-b-12">
							<div class="header-wishlist-item-img">
								<!-- <img src="{{ asset('/images/item-cart-01.jpg') }}" alt="IMG"> -->
								@php
								$filename = '/images/product/' . $wish->id . ' ' . $wish->name . '/' . $wish->id . '_1';
								$imgsrc = asset($filename . '.png');

								if (!file_exists(public_path($filename . '.png'))) {
								if (!file_exists(public_path($filename . '.jpg'))) {
								$imgsrc = asset('/images/unknown.jpg');
								} else {
								$imgsrc = asset($filename . '.jpg');
								}
								}
								@endphp
								<img src="{{ $imgsrc }}" alt="IMG">
							</div>
							<input type="hidden" name="prodid" value="$wish->id">
							<input type="hidden" name="wishlist_id" value="$wish->wishlist_id">
							<div class="header-wishlist-item-txt p-t-8">
								<a href="{{ url('#') }}" class="header-wishlist-item-name m-b-18 hov-cl1 trans-04">
									{{ $wish->name }}
								</a>
								<div class="header-wishlist-item-details">
									<span class="header-wishlist-item-info">
										<!-- number format -->
										Rp {{ number_format($wish->price, 0, ',', '.') }}
									</span>

									<button type="submit" class="add-to-cart-btn" data-product-name="White Shirt Pleat" data-product-price="19.00">Add to Cart</button>
								</div>
							</div>
						</li>
					</form>
					@endforeach
					<!-- <li class="header-wishlist-item flex-w flex-t m-b-12">
						<div class="header-wishlist-item-img">
							<img src="{{ asset('/images/item-cart-02.jpg') }}" alt="IMG">
						</div>

						<div class="header-wishlist-item-txt p-t-8">
							<a href="{{ url('#') }}" class="header-wishlist-item-name m-b-18 hov-cl1 trans-04">
								Converse All Star
							</a>
							<div class="header-wishlist-item-details">
								<span class="header-wishlist-item-info">
									Rp 390.000
								</span>

								<button class="add-to-cart-btn" data-product-name="Converse All Star" data-product-price="39.00">Add to Cart</button>
							</div>
						</div>
					</li> -->

					<!-- <li class="header-wishlist-item flex-w flex-t m-b-12">
						<div class="header-wishlist-item-img">
							<img src="{{ asset('/images/item-cart-03.jpg') }}" alt="IMG">
						</div>

						<div class="header-wishlist-item-txt p-t-8">
							<a href="{{ url('#') }}" class="header-wishlist-item-name m-b-18 hov-cl1 trans-04">
								Nixon Porter Leather
							</a>
							<div class="header-wishlist-item-details">
								<span class="header-wishlist-item-info">
									Rp 170.000
								</span>

								<button class="add-to-cart-btn" data-product-name="Nixon Porter Leather" data-product-price="17.00">Add to Cart</button>
							</div>
						</div>
					</li> -->
				</ul>
				<div class="w-full">
					<div class="header-wish-total w-full p-tb-40">
						5 Other Products in Wishlist
					</div>

					<div class="header-wish-buttons flex-w w-full">
						<a href="{{ url('wishlist') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Wishlist
						</a>

						<!-- <a href="{{ url('wishlist') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
								Check Out
							</a> -->
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Account -->
	<section class="sec-blog bg0 p-t-60 p-b-90">
		<div class="container">
			<div class="row text-dark justify-content-center">
				<div class="col-sm-12 col-lg-3 p-5 p-b-40">
					<div class="row align-items-center" style="height: 20px;">
						<div class="col-12">
							<h5 class="fw-bold">
								Hi, {{$customer[0]->CUST_NAME}}!!
							</h5>
						</div>
					</div>
					<hr>
					<div class="row my-2 justify-content-center">
						<div class="col-11 my-2">
							<a href="{{ route('account-profile') }}" style="text-decoration: none;" class="account-menu">
								<img src="{{ asset('/images/user.png') }}" alt="" width="16px" height="16px">
								<span class="px-2">Profile</span>
							</a>
						</div>
						<div class="col-11 my-2">
							<a href="{{ route('account-transaction') }}" style="text-decoration: none;" class="account-menu">
								<img src="{{ asset('/images/notebook.png') }}" alt="" width="16px" height="16px">
								<span class="px-2">Transaction</span>
							</a>
						</div>
						<div class="col-11 my-2">
							<a href="{{ route('account-password') }}" style="text-decoration: none;" class="account-active">
								<img src="{{ asset('/images/security.png') }}" alt="" width="16px" height="16px">
								<span class="px-2">Change Password</span>
							</a>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-lg-8 p-5 p-b-40" style="background-color: #ededed;">
					<div class="row align-items-center" style="height: 20px;">
						<div class="col-11">
							<h5 class="fw-bold">
								My Profile
							</h5>
						</div>
					</div>
					<hr>
					<form action="{{ route('change-password') }}" method="POST">
						@csrf

						<div class="row my-2 justify-content-center">
							<div class="col-sm-12 col-lg-11">
								<!-- Old Password -->
								<div class="row my-2 align-items-center">
									<div class="col-sm-12 col-lg-3">
										Old Password
									</div>
									<div class="col-sm-12 col-lg-9">
										<input type="password" class="text-dark" name="old_password" required>
									</div>
								</div>

								<!-- New Password -->
								<div class="row my-2 align-items-center">
									<div class="col-sm-12 col-lg-3">
										New Password
									</div>
									<div class="col-sm-12 col-lg-9">
										<input type="password" class="text-dark" name="new_password" required>
									</div>
								</div>

								<!-- Confirm Password -->
								<div class="row my-2 align-items-center">
									<div class="col-sm-12 col-lg-3">
										Confirm Password
									</div>
									<div class="col-sm-12 col-lg-9">
										<input type="password" class="text-dark" name="confirm_password" required>
									</div>
								</div>

								<!-- Error Messages -->
								@if ($errors->any())
								<div class="row my-2 align-items-center">
									<div class="col-sm-12 col-lg-3"></div>
									<div class="col-sm-12 col-lg-9">
										<div class="alert alert-danger">
											<ul>
												@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
									</div>
								</div>
								@endif
								<!-- Success Messages -->
								@if (session('success'))
								<div class="alert alert-success">
									{{ session('success') }}
								</div>
								@endif
								<!-- Submit Button -->
								<div class="row my-2 align-items-center">
									<div class="col-sm-12 col-lg-3"></div>
									<div class="col-sm-12 col-lg-9">
										<input type="submit" value="CHANGE" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
									</div>
								</div>
							</div>
						</div>
					</form>


				</div>
			</div>
		</div>
	</section>

	<!-- Footer -->
	<footer class="bg3 p-t-75 p-b-32">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Categories
					</h4>

					<ul>
						<li class="p-b-10">
							<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
								Women
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
								Men
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
								Clothes
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
								Shoes
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
								Bag
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
								Accesories
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
								Sportswear
							</a>
						</li>

						<li class="p-b-10">
							<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
								Sleepwear
							</a>
						</li>
					</ul>
				</div>

				<!-- <div class="col-sm-6 col-lg-3 p-b-50">
				<h4 class="stext-301 cl0 p-b-30">
					Help
				</h4>

				<ul>
					<li class="p-b-10">
						<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
							Track Order
						</a>
					</li>

					<li class="p-b-10">
						<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
							Returns
						</a>
					</li>

					<li class="p-b-10">
						<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
							Shipping
						</a>
					</li>

					<li class="p-b-10">
						<a href="{{ url('#') }}" class="stext-107 cl7 hov-cl1 trans-04">
							FAQs
						</a>
					</li>
				</ul>
			</div> -->

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						GET IN TOUCH
					</h4>

					<p class="stext-107 cl7 size-201">
						Any questions? Let us know in store at CitraLand CBD Boulevard, Made, Kec. Sambikerep, Surabaya,
						Jawa Timur or call us on (+62) 813-1234-5678
					</p>

					<div class="p-t-27">
						<a href="{{ url('#') }}" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-facebook"></i>
						</a>

						<a href="{{ url('#') }}" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-instagram"></i>
						</a>

						<a href="{{ url('#') }}" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
							<i class="fa fa-pinterest-p"></i>
						</a>
					</div>
				</div>

				<div class="col-sm-6 col-lg-3 p-b-50">
					<h4 class="stext-301 cl0 p-b-30">
						Newsletter
					</h4>

					<form>
						<div class="wrap-input1 w-full p-b-4">
							<input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
							<div class="focus-input1 trans-04"></div>
						</div>

						<div class="p-t-18">
							<button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
								Subscribe
							</button>
						</div>
					</form>
				</div>
			</div>

			<div class="p-t-40">
				<div class="flex-c-m flex-w p-b-18">

					<a href="{{ url('#') }}" class="m-all-1">
						<img src="{{ asset('/images/icons/icon-pay-02.png') }}" alt="ICON-PAY">
					</a>

					<a href="{{ url('#') }}" class="m-all-1">
						<img src="{{ asset('/images/icons/icon-pay-03.png') }}" alt="ICON-PAY">
					</a>
				</div>

				<p class="stext-107 cl6 txt-center">
					Copyright &copy;
					<script>
						document.write(new Date().getFullYear());
					</script> All rights reserved | Made by
					MonoMode</a>

				</p>
			</div>
		</div>
	</footer>


	<!-- Back to top -->
	<div class="btn-back-to-top" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="zmdi zmdi-chevron-up"></i>
		</span>
	</div>

	<!--===============================================================================================-->
	<script src="{{ asset('/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('/vendor/animsition/js/animsition.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('/vendor/select2/select2.min.js') }}"></script>
	<script>
		$(".js-select2").each(function() {
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
	<!--===============================================================================================-->
	<script src="{{ asset('/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script>
		$('.js-pscroll').each(function() {
			$(this).css('position', 'relative');
			$(this).css('overflow', 'hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function() {
				ps.update();
			})
		});
	</script>
	<!--===============================================================================================-->
	<script src="{{ asset('/js/main.js') }}"></script>
	<!-- asdfjdbasfkdf -->
	<script>
		$(document).ready(function() {
			setTimeout(function() {
				$(".alert").fadeOut();
			}, 10000); // Adjust the timeout duration (in milliseconds) as needed
		});
	</script>

</body>

</html>