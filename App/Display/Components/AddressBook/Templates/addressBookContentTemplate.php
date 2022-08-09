<div class="col-xl-4 address">
   <div class="card {{active}}">
      {{id}}
      <div class="card-body">
         <div class="address-content">
            <ul class="address-text">
               <li class="name"> {{prenom}}&nbsp;{{nom}}</li>
               <li class="address-line">{{address1}}</li>
               <li class="address-line">{{address2}}</li>
               <li class="zip-city"><span class="zip_code">{{code_postal}}</span>&nbsp;<span
                     class="city">{{ville}}&nbsp;{{region}}</span></li>
               <li class="state">{{pays}}</li>
               <li class="phone">{{telephone}}</li>
            </ul>
         </div>
         <div class="manage">
            <div class="links">
               <div class="modify-frm">
                  {{formModify}}
               </div>
               &#x7C;
               <div class="erase-frm">
                  {{formErase}}
               </div>
               <!-- &#x7C; -->
               <div class="select-frm">
                  {{FormSelect}}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>