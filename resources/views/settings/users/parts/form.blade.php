<div class="form-row">
  <x-form.input :model="$model" class="col-12 col-md-6 mb-3" label="{{ __('Name') }}" name="name"
    :required="true">
  </x-form.input>

  <x-form.input :model="$model" class="col-12 col-md-6 mb-3" label="{{ __('Email') }}" name="email"
    :required="true">
  </x-form.input>

  <x-form.input class="col-12 col-md-6 mb-3" label="{{ __('Password') }}" name="password" type="password" :required="true">
  </x-form.input>

  <x-form.input class="col-12 col-md-6 mb-3" label="{{ __('Password confirmation') }}" name="password_confirmation"
  type="password" :required="true">
  </x-form.input>
</div>

@can('create', App\Models\Role::class)
  @if(!isset($model) || Auth::user()->id !== $model->id)
    <div class="form-row">
      <div class="col-12 col-md-6 mb-3">
        <label for="role">{{ __('Role') }}</label>
        @if ($roles)
          <select class="form-control" name="role">
            @foreach ($roles as $role)
              <option value="{{ $role->id }}" @selected(is_null($model) ? '' : collect($model->roles)->contains('slug', $role->slug))>
                {{ $role->name }}
              </option>
            @endforeach
          </select>
        @else
          <p>{{ __('No roles.') }}</p>
        @endif

        @error('role')
          <div class="invalid-feedback" id="role_feedback">
            {{ $errors->first('role') }}
          </div>
        @enderror
      </div>
    </div>
  @endif
@endcan
