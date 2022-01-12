<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Prognožu spēle</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <li class="{{Request::is('/') ? 'active' : ''}}">
          <a class="nav-link" aria-current="page" href="/">Sākums</a>
        </li>
        <li class="{{Request::is('leagues') ? 'active' : ''}}">
          <a class="nav-link" href="{{route('leagues.index')}}">Līgas</a>
        </li>
        <li class="{{Request::is('predictions') ? 'active' : ''}}">
          <a class="nav-link" href="/predictions">Prognozes</a>
        </li>
        <li class="{{Request::is('results') ? 'active' : ''}}">
          <a class="nav-link" href="{{route('results.index')}}">Rezultāti</a>
        </li>
        <li class="{{Request::is('contact') ? 'active' : ''}}">
          <a class="nav-link" href="/contact">Saziņa</a>
        </li>
        <li class="{{Request::is('rules') ? 'active' : ''}}">
          <a class="nav-link" href="/rules">Noteikumi</a>
        </li>
        @if(Auth::check())
          @if(auth()->user()->hasRole('admin'))
          <li class="{{Request::is('admin/users') ? 'active' : ''}}">
            <a class="nav-link" href="{{route('admin.users.index')}}">Administrācija</a>
          </li>
          @endif
        @endif
      </ul>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            @if (Auth::check())
            <li class="{{Request::is('/login') ? 'active' : ''}}">
              <a class="nav-link disabled">{{auth()->user()->name}}</a>
            </li>
            <li>
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                  Atteikties
              </a>
              <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </li>
            @else
            <li class="{{Request::is('/login') ? 'active' : ''}}">
              <a class="nav-link" href="{{route('login')}}">Pieteikties</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('register')}}">Reģistrēties</a>
            </li>
            @endif

        </ul>
    </div>
  </div>
</nav>
