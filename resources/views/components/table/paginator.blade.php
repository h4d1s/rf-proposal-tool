@props([
  'paginator' => null
])

@if($paginator && $paginator->total() > 0)

  <nav class="d-flex flex-row align-items-center">
    <div class="mr-auto">
      @if(!$paginator->onFirstPage())
      <a href="{{ $paginator->withQueryString()->previousPageUrl() }}" class="btn icon-muted" data-action="prev">
        <i class="material-icons float-left">arrow_backward</i>
      </a>
      @endif
    </div>

    <div class="ml-auto">
      <span class="text-muted">
        {{ $paginator->currentPage() }}
        {{ __("of") }}
        <span class="js-table-total-pages">
          {{ ceil($paginator->total() / $paginator->perPage()) }}
        </span>
      </span>

      @if($paginator->hasMorePages())
      <a href="{{ $paginator->withQueryString()->nextPageUrl() }}" class="btn icon-muted" data-action="next">
        <i class="material-icons float-right">arrow_forward</i>
      </a>
      @endif
    </div>
  </nav>

@endif
