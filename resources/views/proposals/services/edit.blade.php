@php
  $id = 0;
  if($proposal->pricingTable) {
    $id = $proposal->pricingTable->id;
  }
@endphp

<div id="proposal-services">
  <pricing-table :id="{{ $id }}" currency="{{ $currency }}">
  </pricing-table>
</div>
