<div class="row cart-row">
   <div class="col-sm-2 cart-row__img">
      <img src="{{image}}" alt="cart1" class="img-fluid" style="height:120px;">
   </div>
   <div class="col-sm-8 cart-row__details">
      <h5 class="title">{{title}}</h5>
      <small>By&nbsp;{{categorie}}</small>
      <!-- Rating section -->
      <div class="rating">
         <div class="rating__star text-warning font-size-12">
            <span><i class="fas fa fa-star"></i></span>
            <span><i class="fas fa fa-star"></i></span>
            <span><i class="fas fa fa-star"></i></span>
            <span><i class="fas fa fa-star"></i></span>
            <span><i class="fa-solid fa-star-half-stroke"></i></span>
         </div>
         <a href="#" class="px-2 rating__text">20,534 ratings</a>
      </div>
      <!-- !Rating section -->
      <!-- Produt quantity -->
      <div class="cart-qty">
         {{whishlist_del_frm}}
      </div>
      <!-- !Produt quantity -->
   </div>
   <div class="col-sm-2 text-right cart-row__price">
      <div class="price_wrapper">
         <span class="product_price">{{price}}</span>
      </div>
   </div>
</div>