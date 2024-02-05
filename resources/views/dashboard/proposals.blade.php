<div class="card">
  <div class="card-header card-header-tabs-basic nav" role="tablist">
    @forelse ($proposals as $state => $p)
      <a
        href="#proposals_{{ $state }}"
        @class([ 'active' => $loop->first ])
        data-toggle="tab"
        role="tab"
        aria-controls="proposals_{{ $state }}"
        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
        {{ ucfirst($state) }}
      </a>
    @empty
      <p><em>{{ __("No proposals found.") }}</em></p>
    @endforelse
  </div>

  <div class="list-group tab-content list-group-flush">
    @forelse ($proposals as $state => $p)
      <div
        @class(["tab-pane", "fade", "active" => $loop->first, "show" => $loop->first])
        id="proposals_{{ $state }}">
        @forelse ($p as $proposal)
          <div class="list-group-item list-group-item-action d-flex align-items-center">
            <div class="flex">
              <div class="d-flex align-items-middle">
                <strong class="text-15pt mr-1">
                  <a href="{{ route('proposals.show', $proposal->id) }}">
                      {{ $proposal->name }}
                  </a>
                </strong>
              </div>
              <small class="text-muted">
                {{ $proposal->created_at->diffForHumans() }}
              </small>
            </div>
          </div>
        @empty
          <div class="list-group-item">
            <em>{{ __("No proposals found.") }}</em>
          </div>
        @endforelse
        <div class="card-footer text-center border-0">
          <a class="text-muted" href="{{ route('proposals.index', ["state[]" => $state]) }}">
            {{ __("View All") }}
          </a>
        </div>
      </div>
    @empty
      <p><em>{{ __("No proposals found.") }}</em></p>
    @endforelse
  </div>
</div>
