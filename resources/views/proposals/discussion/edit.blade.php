<div class="border-bottom">
  <div class="flex d-flex flex-column scrollable">
    @forelse ($proposal->discussions as $discussion)
      <div class="d-flex align-items-center mb-2">
        <div class="d-flex align-items-center">
          <a href="#" class="text-body bold">
            @if (
              class_basename($discussion->discussionable) === User::class ||
              class_basename($discussion->discussionable) === Company::class
            )
              {{ $discussion->discussionable->name }}
            @elseif(class_basename($discussion->discussionable) === Client::class)
              {{ $discussion->discussionable->full_name }}
            @endif
          </a>
          <span class="badge badge-secondary ml-1">
            {{ strtolower(class_basename($discussion->discussionable)) }}
          </span>
        </div>
        <div class="ml-auto d-flex align-items-center">
          <small class="text-muted">
            {{ $discussion->created_at->diffForHumans() }}
          </small>
          <a href="{{ route('discussions.delete', $discussion->id) }}" class="ml-1">
            <i class="fa-solid fa-xmark"></i>
          </a>
        </div>
      </div>
      <p>{{ $discussion->body }}</p>
    @empty
      <div class="alert alert-info">
        {{ __('No discussions yet.') }}
      </div>
    @endforelse
  </div>
</div>

<div class="form-group mt-3">
  <div class="mb-3">
    <x-form.textarea id="discussion" name="discussion" label="{{ __('Discussion') }}">
      <x-slot:help>
        {{ __("Your comment will be emailed to the client's email address.") }}
      </x-slot:help>
    </x-form.textarea>
  </div>
</div>

<div class="form-group d-flex justify-content-end">
  <button type="submit" class="btn btn-primary">
    {{ __('Add discussion') }}
  </button>
</div>
