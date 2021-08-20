<?php
$menu_lang = "menu_".App::getLocale();
?>
<!--=========================-->
<!--=        Navbar         =-->
<!--=========================-->
<header id="discohead" class="dt-header">

	<div class="container">
		<a id="logo" style="display: inline-flex;" href="/portal">
			<!-- <img src="{{ url('images/logo_malaysia.png') }}" style="height: 50px;" alt="discovery" class="logo-contrast"> -->
			<img src="{{ url('images/logo_ttpm.png') }}" style="height: 50px;" alt="discovery" class="logo-contrast">
			<!-- <img src="{{ url('images/logo_malaysia.png') }}" style="height: 50px;" alt="discovery" class="logo-normal"> -->
			<img src="{{ url('images/logo_ttpm.png') }}" style="height: 50px;" alt="discovery" class="logo-normal">
		</a>

		<div id="nav-toggle" class="nav-toggle hidden-md" style="margin-top: 10px;">
			<div class="toggle-inner">
				<span></span>
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		<!-- /.nav-toggle -->

		<div id="discovery-main-menu" class="discovery-main-menu">
			<ul id="menu-home" class="menu">

				@foreach($menu as $m)
				<li @if($m->children->count() > 0) class="menu-item-has-children" @endif>
					<a @if($m->url) href="{{ url('portal/'.$m->url) }}" @endif >{{ $m->$menu_lang }}</a>
					@if($m->children->count() > 0)
					<ul class="sub-menu">
						@foreach($m->children as $childmenu)
						<li @if($childmenu->children->count() > 0) class="menu-item-has-children" @endif>
							<a @if($childmenu->url) href="{{ url('portal/'.$childmenu->url) }}" @endif >{{ $childmenu->$menu_lang }}</a>
							@if($childmenu->children->count() > 0)
							<ul class="sub-menu">
								@foreach($childmenu->children as $child)
								<li><a @if($child->url) href="{{ url('portal/'.$child->url) }}" @endif >{{ $child->$menu_lang }}</a></li>
								@endforeach
							</ul>
							@endif
						</li>
						@endforeach
					</ul>
					@endif
				</li>
				@endforeach

				<li><a href="/login"><span class="fa fa-user"></span> {{ __('login.login') }}</a></li>
				<li class="menu-item-has-children">
					<a href="#">
						@if(App::getLocale() == "en")
						<span class="flag-icon flag-icon-us"></span> EN
						@else
						<span class="flag-icon flag-icon-my"></span> MY
						@endif
					</a>
					<ul class="sub-menu">
						<li><a href="#" onclick="changeLang('en')"><span class="flag-icon flag-icon-us"></span> {{ __('new.lang_english') }}</a></li>
						<li><a href="#" onclick="changeLang('my')"><span class="flag-icon flag-icon-my"></span> {{ __('new.lang_malay') }}</a></li>
					</ul>
				</li>

				{{--
				<li class="menu-item-has-children">
					<a href="#">Home</a>
					<ul class="sub-menu">
						<li><a href="index.html">Home One</a></li>
						<li><a href="index-two.html">Home Two</a></li>
						<li><a href="index-three.html">Home Colorful</a></li>
						<li><a href="index-four.html">Home Gradient</a></li>
						<li><a href="index-five.html">Home Typed</a></li>
						<li><a href="index-six.html">Home Particles</a></li>
						<li><a href="index-seven.html">Home Ripples</a></li>
					</ul>
				</li>
				<li><a href="#feature">Service</a></li>
				<li><a href="#about">About</a></li>
				<li>
					<a href="#portfolio">Portfolio</a>
					<!-- <ul class="sub-menu">
				<li class="menu-item-has-children">
					<a href="#">Grid</a>
					<ul class="sub-menu">
						<li><a href="#">2 Column</a></li>
						<li><a href="#">3 Column</a></li>
						<li><a href="#">4 Column</a></li>
					</ul>
				</li>
				<li class="menu-item-has-children">
					<a href="#">Masonry</a>
					<ul class="sub-menu">
						<li><a href="#">2 Column</a></li>
						<li><a href="#">3 Column</a></li>
						<li><a href="#">4 Column</a></li>
					</ul>
				</li>
			</ul> -->
				</li>
				<li><a href="#team">Team</a></li>
				<li class="menu-item-has-children">
					<a href="#">Element</a>
					<ul class="sub-menu">
						<li><a href="accordian.html">Accordian</a></li>
						<li><a href="buttons.html">Buttons</a></li>
						<li><a href="contact-form.html">Contact Form</a></li>
						<li><a href="icon-box.html">Icon Box</a></li>
						<li><a href="testimonial.html">Testimonial</a></li>
						<li><a href="client.html">Client</a></li>
						<li><a href="call-to-action.html">Call to Action</a></li>
						<li><a href="team.html">Team Member</a></li>
						<li><a href="counter.html">Counter</a></li>
						<li><a href="progressbar.html">Progessbar</a></li>
						<li><a href="pricing-table.html">Pricing Table</a></li>
						<li><a href="work-step.html">Work Step</a></li>
					</ul>
				</li>
				<li class="menu-item-has-children">
					<a href="#">Shop</a>
					<ul class="sub-menu">
						<li><a href="product-sidebar.html">Product With Sidebar</a></li>
						<li><a href="product-no-sidebar.html">Product No Sidebar</a></li>
						<li><a href="single-product.html">Single Product</a></li>
						<li><a href="checkout.html">Checkout</a></li>
						<li><a href="cart.html">Cart</a></li>
					</ul>
				</li>
				<li class="menu-item-has-children">
					<a href="#">Blog</a>
					<ul class="sub-menu">
						<li class="menu-item-has-children">
							<a href="#">Blog Standard</a>
							<ul class="sub-menu">
								<li><a href="blog-standard-right.html">Right Sidebar</a></li>
								<li><a href="blog-standard-left.html">Left Sidebar</a></li>
								<li><a href="blog-standard-fullwidth.html">Fullwidth</a></li>
							</ul>
						</li>
						<li class="menu-item-has-children">
							<a href="#">Blog Grid</a>
							<ul class="sub-menu">
								<li><a href="blog-grid-right.html">Right Sidebar</a></li>
								<li><a href="blog-grid-left.html">Left Sidebar</a></li>
								<li><a href="blog-grid-fullwidth.html">Fullwidth</a></li>
							</ul>
						</li>
						<li class="menu-item-has-children">
							<a href="#">Blog List</a>
							<ul class="sub-menu">
								<li><a href="blog-list-right.html">Right Sidebar</a></li>
								<li><a href="blog-list-left.html">Left Sidebar</a></li>
								<li><a href="blog-list-fullwidth.html">Fullwidth</a></li>
							</ul>
						</li>
						<li class="menu-item-has-children">
							<a href="#">Blog Single</a>
							<ul class="sub-menu">
								<li><a href="blog-single-right.html">Right Sidebar</a></li>
								<li><a href="blog-single-left.html">Left Sidebar</a></li>
								<li><a href="blog-single-fullwidth.html">Full Width</a></li>
							</ul>
						</li>

					</ul>
				</li>
				<li><a href="#">Contact</a></li>
				--}}
			</ul>

			<!-- <nav class="secondary-navigation pull-right" style="padding-left: 10px;">
				<ul>
					<li>
						<a href="{{ url('login') }}" class="search-btn">
							<span class="fa fa-user"></span>
						</a>

					</li>
					{{--
					<li>
						<a href="#" class="search-btn">
							<span class="fa fa-search"></span>
						</a>

					</li>
					--}}
				</ul>
			</nav> -->
		</div>
	</div>

	{{--
	<div class="search-box search-elem">
		<button class="close"><i class="fa fa-times"></i></button>
		<div class="inner row">
			<div class="small-12 columns">
				<label class="placeholder" for="search-field">{{ __('portal.search')}}</label>
				<input type="text" id="search-field">
				<button class="submit" type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>
	</div>
	--}}
</header>
<!-- #discohead -->