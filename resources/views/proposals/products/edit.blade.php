<div id="proposal-create-products">
  <select-products
    :attribute-products="{{ $proposal->products->pluck("id") }}"
    currency={{ $currency }}
  />
</div>