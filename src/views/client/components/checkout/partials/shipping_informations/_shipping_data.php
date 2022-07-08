<div class="card">
   <div class="card-body">
      <div class="border p-3 mb-3 rounded info-resume">
         <table class="table table-borderless">
            <tr class="border-bottom contact">
               <td class="title">Contact:</td>
               <td class="value contact-email">donnie1973@hotmail.com</td>
               <td class="link"><a href="#" class="text-highlight" data-bs-toggle="modal"
                     data-bs-target="#modal-box-email">Change</a></td>
            </tr>
            <tr class="border-bottom address">
               <td class="title">Ship to:</td>
               <td class="value ship-to-address">3363 Cook Hill Road, Wallingford,
                  Connecticut(CT),
                  06492,
                  Wallingford CT
                  06492, United
                  States</td>
               <td class="link"><a href="#" class="text-highlight change-ship__btn" data-bs-toggle="modal"
                     data-bs-target="#modal-box-change-address">Change</a></td>
            </tr>
         </table>
      </div>
      {{shippingTitle}}
      <div class="border mb-3 rounded radio-check-group">
         {{form_shipping_method}}
      </div>
      {{buttonsLeft}}
   </div>
   <!-- end card-body -->
</div>