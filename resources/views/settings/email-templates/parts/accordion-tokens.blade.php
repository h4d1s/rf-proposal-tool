<div class="accordion" id="accordionTokens">
  <div class="card shadow-none">
    <div class="card-header" id="tokens">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          {{ __("Available tokens") }}
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="tokens" data-parent="#accordionTokens">
      <div class="card-body">
        <p>{{ __("Proposal tokens:") }}</p>
        <p><code>[LinkToProposal]</code> - this token will generate a clickable link in your emails.</p>
        <p><code>[ProposalName] [ProposalCreatedOn] [ProposalExpiresOn]</code></p>

        <p>{{ __("Customer tokens:") }}</p>
        <p><code>[CustomerName] [CustomerEmail] [CustomerPhone] [CustomerCountry]
          [CustomerCity] [CustomerZip] [CustomerAddress]</code></p>

        <p>{{ __("User tokens:") }}</p>
        <p><code>[UserName] [UserEmail] [UserPhone]</code></p>
      </div>
    </div>
  </div>
</div>
