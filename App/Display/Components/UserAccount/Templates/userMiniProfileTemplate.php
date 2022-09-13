<div class="card mini-profile" style="width:18rem;">
   <div class="card-header mini-profile-header">
      <div class="mini-profile-cover-photo"></div>
      <div class="mini-profile-author d-sm-flex">
         {{userIdentification}}
         <div class="text-center mini-profile-photo">
            <img src="{{profile_image}}" alt="mini-profile Photo" class="img-fluid">
         </div>
         <div class="mini-profile-name">
            <h4 class="name"><span>{{firstName}}</span>&nbsp;
               <span>{{lastName}}</span>
            </h4>
            <p class="email">{{Email}}
            </p>
         </div>
      </div>
   </div>
   <div class="card-body mini-profile-body">
      <div class="mini-profile-title">
         <a class="mini-profile-link" href="{{orders_link}}">
            <p class="title lead"><i class="fa-solid fa-bars"></i>&nbsp;Mes commandes
            </p>
         </a>
      </div>
      <div class="mini-profile-title">
         <a class="mini-profile-link" href="{{address_link}}">
            <p class="title lead"><i class="fa-solid fa-address-card"></i>&nbsp;Mes adresses
            </p>
         </a>
      </div>
      <div class="mini-profile-title">
         <a class="mini-profile-link" href="{{profile_link}}">
            <p class="title lead"><i class="fa-solid fa-user-pen"></i>&nbsp;Mon Profil
            </p>
         </a>
      </div>
      <div class="mini-profile-title">
         <a class="mini-profile-link" href="{{user_card_link}}">
            <p class="title lead"><i class="fa-solid fa-credit-card"></i>&nbsp;Mes Moyens de Paiement
            </p>
         </a>
      </div>
      <div class="mini-profile-details">
         <div class="single-details-item">
            {{remove_account_frm}}
         </div>
      </div>
   </div>
   <div class="mini-profile-footer">
      <div class="mini-profile-title">
         <a class="btn btn-primary w-100 mini-profile-link" href="{{account_route}}"><span class="icon"><i
                  class="fa-solid fa-rotate-left"></i></span><span>Retour a la boutique</span></a>
      </div>
   </div>
</div>