<div class="list-group mb-3">
  @can('viewAny', App\Models\Setting::class)
    <a href="{{ route('settings.edit') }}"
      class="list-group-item @if (request()->routeIs('settings.*')) active @endif list-group-item-action">
      <i class="fa-solid fa-gear mr-1"></i>
      {{ __('Settings') }}
    </a>
  @endcannot

  @can('viewAny', App\Models\EmailTemplate::class)
    <a href="{{ route('email-templates.index') }}"
      class="list-group-item @if (request()->routeIs('email-templates.*')) active @endif list-group-item-action">
      <i class="fa-solid fa-envelope mr-1"></i>
      {{ __('Email templates') }}
    </a>
  @endcannot

  @can('viewAny', App\Models\User::class)
    <a href="{{ route('users.index') }}"
      class="list-group-item @if (request()->routeIs('users.*') || request()->routeIs('profile')) active @endif list-group-item-action">
      <i class="fa-solid fa-user mr-1"></i>
      {{ __('Users') }}
    </a>
  @endcannot

  @can('viewAny', App\Models\ServiceTemplate::class)
  <a href="{{ route('service-templates.index') }}"
    class="list-group-item @if (request()->routeIs('service-templates.*') || request()->routeIs('service-template-items.*')) active @endif list-group-item-action">
    <i class="fa-solid fa-table-list mr-1"></i>
    {{ __('Service templates') }}
  </a>
@endcannot
</div>
