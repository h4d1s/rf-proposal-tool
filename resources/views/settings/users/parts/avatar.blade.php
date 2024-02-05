<div class="form-row">
  <div class="col-12 mb-3">
    <label for="avatar">{{ __('Avatar') }}</label>
    <div id="image-upload">
      @php
        $url = null;
        if (isset($user) && isset($user->avatar)) {
          $url = asset('storage/images/' . $user->avatar->path);
        }
      @endphp
      <image-upload name="avatar" src="{{ $url }}">
      </image-upload>
    </div>

    @error('file')
      <div class="invalid-feedback" id="file_feedback">
        <ul class="list-unstyled mb-0">
          @foreach ($errors->get('file') as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @enderror
  </div>
</div>
