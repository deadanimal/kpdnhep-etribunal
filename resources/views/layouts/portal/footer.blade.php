<!--=========================-->
<!--=        footer         =-->
<!--=========================-->
<footer id="footer" class="footer-fixed">
	{{--
	<div class="container">
		<div class="footer-details">
			<div class="col-md-3">
				<h4 style='color:white;'>{{ __('portal.links')}}</h4>
				<p style="text-align: center; margin-top: 10px;"">
					<a href="https://etribunalv2.kpdnkk.gov.my/portal/home" target="_blank"><img src="{{ url('images/logo_kpdnkk.png') }}" style="height: 40px;"></a>
					<a href="http://www.fomca.org.my/v1/" target="_blank"><img src="{{ url('images/logo_fomca.jpg') }}" style="height: 40px;"></a>
					<a href="http://www.jbg.gov.my/index.php/ms-my/" target="_blank"><img src="{{ url('images/logo_jbg.jpg') }}" style="height: 40px;"></a>
				</p>
			</div>
			<div class="col-md-2">
				<h4 style='color:white;'>{{ __('portal.total_visitors')}}</h4>
				<h1 style="color: #777;">{{ sprintf("%06d", env("PORTAL_COUNTER")) }}</h1>
			</div>
			<div class="col-md-7">
				<h4 style='color:white;'>{{ __('portal.most_visited')}}</h4>
				<p style="text-align: center; margin-top: 10px;">
					<a href="{{ url('portal/directory/branches') }}" class='btn btn-default btn-xs' style="margin-bottom: 5px;">{{ __('portal.branch_address')}}</a>
					<a href="{{ url('login') }}" class='btn btn-default btn-xs' style="margin-bottom: 5px;">e-Tribunal V2</a>
					<a href="{{ url('portal/claim/type') }}" class='btn btn-default btn-xs' style="margin-bottom: 5px;">{{ __('portal.claims_type')}}</a>
					<a href="{{ url('portal/contact') }}" class='btn btn-default btn-xs' style="margin-bottom: 5px;">{{ __('portal.contact_us')}}</a>
					<a href="{{ url('portal/faq') }}" class='btn btn-default btn-xs' style="margin-bottom: 5px;">{{ __('portal.faq')}}</a>
				</p>
			</div>
		</div>
	
	</div>
	--}}

	<!-- /.container -->
	<div class="copy-right text-center">
		<p style='line-height: 16px;'>
			{{ __('portal.total_visitors')}} : {{ sprintf("%06d", env("PORTAL_COUNTER")) }} <br>
			© {{ date('Y') }} - {!! __('portal.copyright')!!}
		</p>
	</div>
</footer>
<!-- /#footer -->