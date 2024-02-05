<div class="card">
    <div class="card-header bg-white d-flex align-items-center">
        <h4 class="card-header__title flex m-0">
          {{ __("Client Activity") }}
        </h4>
    </div>
    <div class="list-group tab-content list-group-flush">
      @forelse ($activities as $activity)
        <div class="list-group-item list-group-item-action d-flex align-items-center">
          <div class="flex">
            <div class="d-flex align-items-middle">
              <strong class="text-15pt mr-1">
                {{ $activity->causer->full_name }} {{ $activity->activity_type->name }}
                <a href="{{ route('proposals.show', $activity->subject->id) }}">
                  {{ $activity->subject->name }}
                </a>
              </strong>
            </div>
            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
          </div>
        </div>
      @empty
        <div class="card-body">
          <em>{{ __("No activities found.") }}</em>
        </div>
      @endforelse
    </div>
</div>
