<div class="moyens-de-paiement">
   <div class="row g-3">
      <div class="accordion" id="credit-card">
         {{userCard_item}}
      </div>
   </div>
   <div class="row g-3">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_new_card">
         Ajouter
      </button>
      <!-- Modal -->
      <div class="modal fade" id="add_new_card" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="add_new_cardLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="add_new_cardLabel">Add New Card</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <div class="card">
                     <form>
                        <span id="card-header">Saved cards:</span>
                        {{card_list}}
                        <span id="card-header">Add new card:</span>
                        <div class="row-1">
                           <div class="row row-2">
                              <span id="card-inner">Card holder name</span>
                           </div>
                           <div class="row row-2">
                              <input type="text" placeholder="Bojan Viner">
                           </div>
                        </div>
                        <div class="row three">
                           <div class="col-7">
                              <div class="row-1">
                                 <div class="row row-2">
                                    <span id="card-inner">Card number</span>
                                 </div>
                                 <div class="row row-2">
                                    <input type="text" placeholder="5134-5264-4">
                                 </div>
                              </div>
                           </div>
                           <div class="col-2">
                              <input type="text" placeholder="Exp. date">
                           </div>
                           <div class="col-2">
                              <input type="text" placeholder="CVV">
                           </div>
                        </div>

                     </form>
                  </div>
               </div>
               <div class="btn-grps modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <button class="d-flex btn btn-primary btn-add"><b>Add card</b></button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>