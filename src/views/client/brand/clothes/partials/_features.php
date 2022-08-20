<section class="my-5 pb-5 products-features container-fluid" id="products-features">
    <div class="text-center mt-5 py-5 features-title">
        <h3 class="title">Our Features</h3>
        <hr class="horizontal-line mx-auto">
        <p class="descr">Here you can check out our new products with fair price on Rymo</p>
    </div>
    <div class="row mx-auto products-group">
        <?php if (isset($this->products) && count($this->products)) : shuffle($this->products); ?>
        <?php foreach ($this->products as $product) : ?>
        <?php if ($product->categorie == 'Chaussures') :?>
        <div class="products-item text-center col-lg-3 col-md-4 col-12">
            <a href="<?= PROOT ?>details/<?= $product->p_slug ?>">
                <div style="overflow:hidden;">
                    <img src="<?=$product->p_media != '' ? ImageManager::asset_img(unserialize($product->p_media)[0]) : ImageManager::asset_img('featured/1.jpg')?>"
                        alt="" class="img-fluid mb-3">
                </div>
            </a>
            <div class="star">
               <i class="fa-solid fa-star"></i>
               <i class="fa-solid fa-star"></i>
               <i class="fa-solid fa-star"></i>
           <i class="fa-solid fa-star-half-stroke"></i>
           <i class="fa-solid fa-star-half-stroke"></i>
            </div>
            <h5 class="product-name"><?= $product->p_title ?? 'Unknown' ?>
            </h5>
            <h4 class="product-price price"> <span
                    class="product_regular_price"><?= $this->productManager->get_money()->getAmount($product->p_regular_price) ?? 0 ?></span>
            </h4>
            <button class="buy-btn">Buy Now</button>
        </div>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>