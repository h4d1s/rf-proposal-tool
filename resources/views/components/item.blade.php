@props([
  'item' => null,
	'href' => null
])

@if($item && $href)
	<div class="col rf-item">
		<div class="card stories-card-popular">
			<img src="" alt="{{ $item->name }}" class="card-img">
			<div class="stories-card-popular__content">
				<div class="stories-card-popular__title card-body text-left">
					<small class="text-muted text-uppercase">
						$<span>{{ $item->price }}</span>
					</small>

					<h4 class="card-title m-0">
						<a href="{{ route('collections.show', $item->id) }}">
							<span>{{ $item->name }}</span>
						</a>
					</h4>
				</div>
			</div>
		</div>
	</div>
@endif
