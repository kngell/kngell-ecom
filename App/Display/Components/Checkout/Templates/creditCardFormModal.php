<div class="modal fade" id="payment-box" tabindex="-1" aria-labelledby="payment-boxLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Montant à payer: &nbsp;<span class="price">{{price}}</span></h5>
            <button type="button" class="btn-close text-light" data-bs-dismiss="modal"></button>
         </div>
         <div class="modal-body">
            <div class="form-wrapper">
               {{creditCardTemplate}}
            </div>
         </div>
      </div>
   </div>
</div>