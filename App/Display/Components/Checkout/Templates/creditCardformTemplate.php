<div id="stripeErr"></div>
<div id="card-error" role="alert"></div>
<input type="hidden" id="stripe_key" value="{{stripeKey}}">
<div class="complete-payment-frm" id="complete-payment-frm">
   <div class="bg"></div>
   <div class="p-card" id="p-card">
      <img src="{{cc_image}}" class="chip" alt="Credit Card Icon">
      <div class="logo"></div>
      <h2 class="bankName" contenteditable="true">Bank Name</h2>
      <div class="form">
         {{cardHolder}}
         <div class="input-box">
            <span>Card Number</span>
            <div id="card-element"></div>
         </div>
         <div class="group">
            <div class="input-box">
               <span>Card Expiry</span>
               <div id="card-exp"></div>
            </div>
            <div class="input-box">
               <span>Card Cvc</span>
               <div id="card-cvc"></div>
            </div>
         </div>
      </div>
   </div>
   <button type="submit" id="complete-order" class="btn"><span> Complete Order</button>
</div>