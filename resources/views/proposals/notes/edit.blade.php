<div class="border-bottom">
  <div class="flex d-flex flex-column scrollable">
    @forelse ($proposal->notes as $note)
      <div class="d-flex align-items-center mb-2">
        <a href="{{ route('users.show', $note->user->id) }}" class="text-body bold">
          {{ $note->user->name }}
        </a>
        @foreach ($note->user->roles as $role)
          <span class="badge badge-secondary ml-1">
            {{ strtolower($role->name) }}
          </span>
        @endforeach
        <div class="ml-auto d-flex align-items-center">
          <small class="text-muted">
            {{ $note->created_at->diffForHumans() }}
          </small>
          <a href="{{ route('notes.delete', $note->id) }}" class="ml-1">
            <i class="fa-solid fa-xmark"></i>
          </a>
        </div>
      </div>
      <p>{{ $note->body }}</p>
    @empty
      <div class="alert alert-info">
        {{ __('No notes yet.') }}
      </div>
    @endforelse
  </div>
</div>

<div class="form-group mt-3">
  <div class="mb-3">
    <x-form.textarea id="note" name="note" label="{{ __('Note') }}">
      <slot name="help">
        {{ __("Notes are internal. Your clients can't see them.") }}
      </slot>
    </x-form.textarea>
  </div>
</div>

<div class="form-group d-flex justify-content-end">
  <button type="submit" class="btn btn-primary">
    {{ __('Add note') }}
  </button>
</div>
