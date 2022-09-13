<div class="infos-personnelles">
   <div class="tabs">
      {{user_profile_menu}}
   </div>

   <div class="tab-content">
      <div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
         <div class="row g-0">
            {{user_profile_data}}
         </div>
      </div>
      <div class="tab-pane" id="edit-profile" role="tabpanel" aria-labelledby="edit-profile-tab">
         <div class="row g-0">
            <div class="user-form-box">
               {{user_profile_formdata}}
            </div>
         </div>
      </div>
      <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
         <div class="row g-3">
            <div class="col-md-6">
               <div class="form-box">
                  <form action="">

                  </form>
               </div>
            </div>
            <div class="col-md-6">

            </div>
         </div>
      </div>
   </div>
</div>