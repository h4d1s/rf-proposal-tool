<nav class="navbar navbar-expand-sm navbar-main navbar-dark bg-dark">
  <a href="{{ route('dashboard') }}" class="navbar-brand">
    <x-application-logo color="white"></x-application-logo>
    <span>{{ config('app.name') }}</span>
  </a>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-collapse collapse ml-auto" id="navbarSupportedContent">
    <ul class="nav navbar-nav">
      <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle @if (request()->routeIs('dashboard')) active @endif"
          data-toggle="dropdown">
          {{ __('Dashboard') }}
        </a>
        <div class="dropdown-menu">
          <a href="{{ route('dashboard') }}" class="dropdown-item @if (request()->routeIs('dashboard')) active @endif">
            {{ __('Dashboard') }}
          </a>

          @can('create', App\Models\Proposal::class)
            <a href="{{ route('proposals.create') }}"
              class="dropdown-item @if (request()->routeIs('proposals.create')) active @endif">
              {{ __('New proposal') }}
            </a>
          @endcan

          @can('create', App\Models\Project::class)
            <a href="{{ route('projects.create') }}"
              class="dropdown-item @if (request()->routeIs('projects.create')) active @endif">
              {{ __('New project') }}
            </a>
          @endcan

          @can('create', App\Models\Client::class)
            <a href="{{ route('clients.create') }}" class="dropdown-item @if (request()->routeIs('clients.create')) active @endif">
              {{ __('New client') }}
            </a>
          @endcan
        </div>
      </li>

      @can('viewAny', App\Models\Collection::class)
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle @if (request()->routeIs('collections.*')) active @endif"
            data-toggle="dropdown">
            {{ __('Collections') }}
          </a>
          <div class="dropdown-menu">
            <a href="{{ route('collections.index') }}" class="dropdown-item">
              {{ __('Collections') }}
            </a>
            <a href="{{ route('collections.create') }}" class="dropdown-item">
              {{ __('Create collection') }}
            </a>

            @can('viewAny', App\Models\Product::class)
              <a href="{{ route('products.index') }}" class="dropdown-item">
                {{ __('Products') }}
              </a>
            @endcan
          </div>
        </li>
      @endcan

      @can('viewAny', App\Models\Proposal::class)
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle @if (request()->routeIs('proposals.*')) active @endif"
            data-toggle="dropdown">
            {{ __('Proposals') }}
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="{{ route('proposals.index') }}">
              {{ __('Proposals') }}
            </a>
            <a class="dropdown-item" href="{{ route('proposals.index', ['state[]' => 'sent']) }}">
              {{ __('Sent') }}
            </a>
            <a class="dropdown-item" href="{{ route('proposals.index', ['state[]' => 'viewed']) }}">
              {{ __('Viewed') }}
            </a>
            <a class="dropdown-item" href="{{ route('proposals.index', ['state[]' => 'approved']) }}">
              {{ __('Approved') }}
            </a>
            <a class="dropdown-item" href="{{ route('proposals.index', ['state[]' => 'rejected']) }}">
              {{ __('Rejected') }}
            </a>
          </div>
        </li>
      @endcan

      @can('viewAny', App\Models\Project::class)
        <li class="nav-item dropdown">
          <a href="{{ route('projects.index') }}" class="nav-link @if (request()->routeIs('projects.*')) active @endif">
            {{ __('Projects') }}
          </a>
        </li>
      @endcan

      @can('viewAny', [App\Models\Client::class, App\Models\Company::class])
        <li class="nav-item dropdown">
          <a href="#" class="nav-link dropdown-toggle"
            data-toggle="dropdown">
            {{ __('Customers') }}
          </a>
          <div class="dropdown-menu">
            <a href="{{ route('clients.index') }}" class="dropdown-item">
              {{ __('Clients') }}
            </a>
            <a href="{{ route('companies.index') }}" class="dropdown-item">
              {{ __('Companies') }}
            </a>
          </div>
        </li>
      @endcan
    </ul>
    <div class="navbar-collapse" id="navbarSupportedContent">
      <ul class="nav navbar-nav collapse border-left navbar-height align-items-center d-none d-sm-flex">
        <li class="nav-item dropdown">
          <a href="#account_menu" class="nav-link dropdown-toggle" data-toggle="dropdown" data-caret="false">
            @if (Auth::user()->avatar)
              <img src="{!! asset('storage/images/' . Auth::user()->avatar->path) !!}" class="img-fluid rounded-circle" width="30" height="30"
                alt="{{ __('Avatar') }}" />
            @else
              <img src="{!! asset('storage/images/avatars/default-avatar.png') !!}" class="img-fluid rounded-circle" width="30" height="30"
                alt="{{ __('Avatar') }}" />
            @endif
          </a>
          <div id="account_menu" class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-item-text dropdown-item-text--lh">
              <div><strong>{{ Auth::user()->name }}</strong></div>
              <span>{{ Auth::user()->email }}</span>
            </div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item @if (request()->routeIs('user.edit')) active @endif" href="{{ route('profile') }}">
              {{ __('My profile') }}
            </a>
            <a class="dropdown-item @if (request()->is('settings/*')) active @endif"
              href="{{ route('settings.index') }}">
              {{ __('Settings') }}
            </a>
            <div class="dropdown-divider"></div>

            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Logout') }}
              </a>
            </form>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
