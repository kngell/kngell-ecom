<div class="form-wrapper">
   {{form_begin}}
   <div class="form-step form-step-active" id="order-information" data-step="1">
      {{userInfos}}
   </div>
   <div class="form-step" id="shipping-information" data-step="2">
      {{shippingInfos}}
   </div>
   <div class="form-step" id="billing-information" data-step="3">
      {{billiingInfos}}
   </div>
   <div class="form-step" id="payment-information" data-step="4">
      {{paiementInfos}}
   </div>
   {{form_end}}
   {{formDiscount}}
</div>