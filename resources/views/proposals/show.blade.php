@extends('layouts.blank')

@section('content')

  @php
    $currency = $settings->where("key", "currency")->first()->value;
  @endphp

  @if($is_expired && request()->filled("t"))
    <div class="text-center py-4">
      <i class="fa-solid fa-circle-xmark text-danger h2 mb-3"></i>
      <p class="h4">{{ __("Proposal expired.") }}</p>
      <a href="#" class="js-btn-request-new-proposal">{{ __("Request a new one") }}</a>
    </div>
  @else
    <div class="container">
      <div class="row">
        <div class="col-4">
          <div class="position-sticky proposal-navigation">
              @if(!request()->filled("t"))
                <a href="{{ route("proposals.edit", $proposal) }}" class="btn btn-primary">
                  {{ __("Back") }}
                </a>
              @endif

              <div id="proposal-scroll" class="list-group my-3">
                <a class="list-group-item list-group-item-action active" href="#cover-page">{{ __("Cover Page") }}</a>
                <a class="list-group-item list-group-item-action" href="#cover-letter">{{ __("Cover letter") }}</a>
                <a class="list-group-item list-group-item-action" href="#products">{{ __("Products") }}</a>
                <a class="list-group-item list-group-item-action" href="#services">{{ __("Services") }}</a>
                <a class="list-group-item list-group-item-action" href="#conclusion">{{ __("Conclusion") }}</a>
              </div>

              @if($proposal->state->name === App\Enums\ProposalState::Viewed->value && request()->filled("t"))
                <form class="actions my-3" method="POST" action="{{ route('proposals.action', $proposal) }}">
                  @csrf
                  @method("POST")
                  <input type="hidden" name="t" value="{{ request()->get("t") }}" />

                  <button type="submit" name="action" value="approved" class="btn btn-success">
                    <i class="fa-solid fa-check"></i> {{ __("Approve") }}
                  </button>
                  <button type="submit" name="action" value="rejected" class="btn btn-danger">
                    <i class="fa-solid fa-xmark"></i> {{ __("Reject") }}
                  </button>
                </form>
              @else
                  <p>{{ __("Current state:") }} <em>{{ $proposal->state->name }}</em></p>
              @endif

              @if(request()->filled("t"))
                @if($proposal->state->name === App\Enums\ProposalState::Approved->value)
                  @if($is_paid)
                    <p>{{ __("Status:") }} <span class="text-success">{{ __("Paid") }}</span></p>
                  @else
                    <a
                      href="{{ route("checkout", [ "t" => request("t") ]) }}"
                      class="btn btn-primary">
                      <i class="fa-regular fa-credit-card"></i> {{ __("Pay") }}
                    </a>
                  @endif
                @endif

                <button
                  type="button"
                  class="btn btn-secondary"
                  data-toggle="modal"
                  data-target="#discussionModal">
                  <i class="fa-solid fa-comments"></i>&nbsp;
                  {{ __("Disccuss") }} ({{ $proposal->discussions()->count() }})
                </button>
              @else 
                <p>
                  {{ __("Status:") }}
                  @if($is_paid)
                    <span class="text-success">{{ __("Paid") }}</span>
                  @else
                    <span class="text-danger">{{ __("Unpaid") }}</span>
                  @endif
                </p>
              @endif
          </div>
        </div>
        <div class="col-8 scroll-container">
            <div data-spy="scroll" data-target="#proposal-scroll" data-offset="0">
                <div class="proposal-section" id="cover-page">
                  <h2>{{ $proposal->project->name }}</h2>
                  <p>
                    {{ __("TO:") }} <br>
                    @if($customer->getMorphClass() === "App\Models\Client")
                      {{ $customer->full_name }}
                    @else
                      {{ $customer->name }}
                    @endif <br>
                    {{ $customer->email }} <br>
                    {{ $customer->phone }}
                  </p>
                  <p>
                    {{ __("FROM:") }} <br>
                    {{ $proposal->user->name }} <br>
                    {{ $proposal->user->email }} <br>
                    {{ $proposal->user->phone }}
                  </p>
                </div>
                <div class="proposal-section" id="cover-letter">
                  <h4>{{ __("Cover letter") }}</h4>
                  @if($proposal->cover_letter)
                    <p>{!! nl2br($proposal->cover_letter) !!}</p>
                  @else
                    <em>{{ __("No cover letter found.") }}</em>
                  @endif
                </div>
                <div class="proposal-section" id="products">
                  <h4>{{ __("Products") }}</h4>

                  @if($proposal->products->count() > 0)
                    <table class="table mb-0">
                      <thead>
                        <tr>
                          <th scope="col">{{ __("Name") }}</th>
                          <th scope="col">{{ __("Description") }}</th>
                          <th scope="col">{{ __("Price") }}</th>
                          <th scope="col">{{ __("Image") }}</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($proposal->products as $product)
                        <tr>
                          <td>{{ $product->name }}</td>
                          <td>{{ $product->description }}</td>
                          <td>{{ $currency }}{{ $product->price }}</td>
                          <td><img src="{{ asset("storage/images/" . $product->images()->first()->path) }}" class="img-fluid" /></td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                    <hr class="mt-1">
                    <div class="text-right">
                      {{ __("Total:") }} {{ $currency }}{{ $proposal->products->sum('price') }}
                    </div>
                  @else
                    <em>{{ __("No products found.") }}</em>
                  @endif
                </div>
                <div class="proposal-section" id="services">
                    <h4>{{ __("Services") }}</h2>
                    @if($proposal->pricingTable)
                      <table class="table mb-0">
                        <thead>
                          <tr>
                            <th scope="col">{{ __("Name") }}</th>
                            <th scope="col">{{ __("Description") }}</th>
                            <th scope="col">{{ __("Qty") }}</th>
                            <th scope="col">{{ __("Price") }}</th>
                            <th scope="col">{{ __("Unit") }}</th>
                            <th scope="col">{{ __("Total") }}</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($proposal->pricingTable->items as $item)
                          <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $currency }}{{ $item->price }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>{{ $currency }}{{ $item->qty * $item->price }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <hr class="mt-1">
                      <div class="text-right">
                        {{ __("Total:") }}{{ $currency }}{{ $proposal->pricingTable->total }}
                      </div>
                    @else
                      <p><em>{{ __("No services found.") }}</em></p>
                    @endif
                </div>
                <div class="proposal-section" id="conclusion">
                  <h4>{{ __("Conclusion") }}</h4>
                  @if($proposal->conclusion)
                    <p>{!! nl2br($proposal->conclusion) !!}</p>
                  @else
                    <em>{{ __("No conclusion found.") }}</em>
                  @endif
                </div>
            </div>
        </div>
      </div>
    </div>
  @endif

  @if(!is_null($customer))
    <div class="modal fade" id="discussionModal" tabindex="-1" aria-labelledby="discussionModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" id="proposal-discussion">
          <div class="modal-header">
          <h5 class="modal-title" id="discussionModalLabel">{{ __("Disccuss") }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body">
            <discussion
              :proposal_id="{{ $proposal->id }}"
              :customer_id="{{ $customer->id }}"
              customer_type="{{ $customer->getMorphClass() }}"
              ref="discussionComponentRef"></discussion>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
            <button type="submit" class="btn btn-primary" @click.prevent="onSend">{{ __("Send message") }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection

@push('scripts')
  @vite('resources/js/pages/proposals/show.ts')
@endpush