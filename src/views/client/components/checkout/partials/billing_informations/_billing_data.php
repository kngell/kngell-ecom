<div class="card">
   <div class="card-body">
      <div class="border p-3 mb-3 rounded info-resume">
         <table class="table table-borderless">
            <tr class="border-bottom contact">
               <td>Contact:</td>
               <td class="value contact-email">donnie1973@hotmail.com</td>
               <td><a href="#" class="text-highlight" data-bs-toggle="modal"
                     data-bs-target="#modal-box-email">Change</a></td>
            </tr>
            <tr class="border-bottom address">
               <td class="title">Ship to:</td>
               <td class="value ship-to-address">3363 Cook Hill Road, Wallingford,
                  Connecticut(CT), 06492,
                  Wallingford CT
                  06492, United
                  States</td>
               <td><a href="#" class="text-highlight change-ship__btn" data-bs-toggle="modal"
                     data-bs-target="#modal-box-change-address">Change</a></td>
            </tr>
            <tr class="border-bottom method">
               <td class="title">Shipping Method</td>
               <td class="shipping_method"> <span class="method_title">FedEx Ground
                  </span> &nbsp;<span class="price">$8.73</span> </td>
               <td><a href="#" class="text-highlight" data-bs-toggle="modal"
                     data-bs-target="#modal-box-shipping">Change</a></td>
            </tr>
            <tr class="border-bottom bill-address-ckeck" style="display: none;">
               <td class="title">bill to:</td>
               <td class="value bill-to-address">3363 Cook Hill Road, Wallingford,
                  Connecticut(CT), 06492,
                  Wallingford CT
                  06492, United
                  States</td>
               <td><a href="#" class="text-highlight change-bill__btn" data-bs-toggle="modal"
                     data-bs-target="#modal-box-change-address">Change</a></td>
            </tr>
         </table>
      </div>
      {{billingTitle}}
      <p class="infos-transaction">Select the address that matches your card or
         payment
         method.</p>
      {{billingFrom}}
   </div>
   {{buttonsLeft}}
   <!-- end card-body -->
</div>