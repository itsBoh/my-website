<header class="header-v4">
	<!-- Header desktop -->
	<div class="container-menu-desktop">
		<!-- Topbar -->
		<div class="top-bar">
			<div class="content-topbar flex-sb-m h-full container">
				<div class="left-top-bar">
					Gratis ongkir dengan minimum pembelanjaan Rp 500.000
				</div>
				<div class="right-top-bar flex-w h-full">
					@if(session('customer'))
					<h3 class="flex-c-m trans-04 p-lr-25">Hi, welcome back {{ session('customer')->CUST_ID }}</h3>
					<a href="{{ url('account-profile') }}" class="flex-c-m trans-04 p-lr-25">
						My Account
					</a>
					<a href="{{ route('logout') }}" class="flex-c-m trans-04 p-lr-25">
						Log Out
					</a>
					@else
					<a href="{{ url('login') }}" class="flex-c-m trans-04 p-lr-25">
						Log In
					</a>
					@endif
				</div>
			</div>
		</div>

		<div class="wrap-menu-desktop how-shadow1">
			<nav class="limiter-menu-desktop container">

				<!-- Logo desktop -->
				<a href="{{ url('#') }}" class="logo">
					<img src="{{ asset('/images/icons/logo-01.png') }}" alt="IMG-LOGO">
				</a>

				<!-- Menu desktop -->
				<div class="menu-desktop">
					<ul class="main-menu">
						<li>
							<a href="{{ url('index') }}">Home</a>
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
					<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
						<i class="zmdi zmdi-search"></i>
					</div>

					<div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart" data-notify="2">
						<i class="zmdi zmdi-shopping-cart"></i>
					</div>

					<div class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-wishlist" data-notify="0" id="wishlist-btn">
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
			<a href="{{ url('login') }}"><img src="{{ asset('/images/icons/logo-01.png') }}" alt="IMG-LOGO"></a>
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
					<a href="{{ url('account-profile') }}" class="flex-c-m trans-04 p-lr-25">
						My Account
					</a>
					<a href="{{ url('login') }}" class="flex-c-m trans-04 p-lr-25">
						Log In
					</a>
				</div>
			</li>
		</ul>
		<ul class="main-menu-m">
			<li>
				<a href="{{ url('index') }}">Home</a>
			</li>

			<li>
				<a href="{{ url('product') }}">Shop</a>
			</li>

			<li>
				<a href="{{ url('shoping-cart') }}">Cart</a>
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
	<div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
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
	</div>
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
				@if(session('customer'))
				@foreach($results as $result)
				<li class="header-cart-item flex-w flex-t m-b-12">
					<div class="header-cart-item-img">
						<img src="{{ asset('/images/item-cart-01.jpg') }}" alt="IMG">
					</div>
					<div class="header-cart-item-txt p-t-8">
						<a href="{{ url('#') }}" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
							{{$result->PROD_NAME}}
						</a>

						<span class="header-cart-item-info">
							{{$result->CART_QTY}} x Rp {{$result->PROD_PRICE}}
						</span>
					</div>
				</li>
				@endforeach
				@endif
			</ul>

			<div class="w-full">
				<div class="header-cart-total w-full p-tb-40">
					Total: Rp 750.000
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
				@if(session('customer'))
					@foreach($wishlists as $key => $wishlist)
					<form action="" method="get">
						<li class="header-wishlist-item flex-w flex-t m-b-12">
							<div class="header-wishlist-item-img">
								<img src="{{ asset('/images/item-cart-01.jpg') }}" alt="IMG">
							</div>
							<input type="hidden" name="prodid{{$key}}" value="">
							<div class="header-wishlist-item-txt p-t-8">
								<a href="{{ url('#') }}" class="header-wishlist-item-name m-b-18 hov-cl1 trans-04">
									{{$wishlist->PROD_NAME}}
								</a>
								<div class="header-wishlist-item-details">
									<span class="header-wishlist-item-info">
										Rp {{$wishlist->PROD_PRICE}}
									</span>

									<button class="add-to-cart-btn" type="submit">Add to Cart</button>
								</div>
							</div>
						</li>
					</form>
					@endforeach
				@endif
			</ul>
			<div class="w-full">
				<div class="header-wish-total w-full p-tb-40">
					5 Other Products in Wishlist
				</div>
				<div class="header-wish-buttons flex-w w-full">
					<a href="{{ view('wishlist') }}" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
						View Wishlist
					</a>
				</div>
			</div>
		</div>
	</div>
</div>