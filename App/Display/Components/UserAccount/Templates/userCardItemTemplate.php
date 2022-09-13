<div class="accordion-item">
   <div class="accordion-header" id="headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
         aria-expanded="false" aria-controls="collapseThree">
         <div class="row credit-card-entete">
            <div class="col-sm-8">
               <div class="cc-left-side">
                  <span class="cc-img cc-ls-item">
                     {{card_icon}}
                  </span>
                  <span class="cc-title cc-ls-item">
                     {{brand}}
                  </span>
                  <span class="cc-number cc-ls-item">
                     ...{{last4}}
                  </span>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="cc-right-side">
                  <span class="cc-expiry-titles">Date d'expiration :</span>&nbsp;<span
                     class="cc-expiry-date">{{expiry}}</span>
               </div>
            </div>
         </div>
      </button>
   </div>
   <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
      data-bs-parent="#credit-card">
      <div class="accordion-body">
         <div class="row g-3 cc-content-wrapper">
            <div class="col-sm-8">
               <div class="cc-name-title">Nom sur la carte :</div>
               <div class="cc-name-text">{{card_holder}}</div>
            </div>
            <div class="col-sm-4">
               <div class="cc-invoice-wrapper">
                  <div class="cc-invoice-title">Adresse de facturation :</div>
                  <ul class="cc-invoice-text">
                     <li class="name"> Daniel AKONO</li>
                     <li class="address-line">28 Boulevard de l'évasion</li>
                     <li class="zip-city"><span class="zip_code">95800</span><span class="city">Cergy</span>
                     </li>
                     <li class="state">France</li>
                     <li class="phone">01 23 65 78 98</li>
                  </ul>
               </div>
            </div>
         </div>
         <div class="row g-3 cc-paiement-manage">
            <div class="col-sm-8 d-flex">
               <div class="cc-replace"><span class="cc-replace-title">Perdue ou volée
                     ?</span>&nbsp;<a href="" class="cc-replace-link">Replacer cette
                     carte</a></div>
            </div>
            <div class="col-sm-4">
               <span class="btn">Supprimer</span><span class="btn">Modifier</span>
            </div>
         </div>
      </div>
   </div>
</div>