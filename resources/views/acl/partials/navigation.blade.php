<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">{{ trans('new.toogle_nav') }}</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">{{ trans('new.entrust_gui') }}</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="{{ (Request::is('*syarikats*') ? 'active' : '') }}"><a href="{{ route('entrust-gui::syarikats.index') }}">{{ trans('entrust-gui::navigation.syarikats') }}</a></li>
        <li class="{{ (Request::is('*lpfs*') ? 'active' : '') }}"><a href="{{ route('entrust-gui::lpfs.index') }}">{{ trans('entrust-gui::navigation.lpfs') }}</a></li>
        <li class="{{ (Request::is('*users*') ? 'active' : '') }}"><a href="{{ route('entrust-gui::users.index') }}">{{ trans('entrust-gui::navigation.users') }}</a></li>
        <li class="{{ (Request::is('*roles*') ? 'active' : '') }}"><a href="{{ route('entrust-gui::roles.index') }}">{{ trans('entrust-gui::navigation.roles') }}</a></li>
        <li class="{{ (Request::is('*permissions*') ? 'active' : '') }}"><a href="{{ route('entrust-gui::permissions.index') }}">{{ trans('entrust-gui::navigation.permissions') }}</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
