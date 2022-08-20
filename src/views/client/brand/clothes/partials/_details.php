<section class="container sproduct my-5 pt-5" id="sproduct">
    <div class="row mt-5 images">
        <?php if ($this->p_details->count() === 1) :?>
        <?php $p = current($this->p_details->get_results())?>
        <div class="col-lg-5 col-md-12 col-12">
            <img src="<?= isset($p->p_media) ? $p->p_media[0] : ImageManager::asset_img('shop/1.jpg')?>"
                class="img-fluid w-100 pb-1" id="main-img" alt="">
            <div class="small-img-group">
                <?php if (isset($p->p_media) && count($p->p_media) > 1):?>
                <?php for ($i = 1; $i < count($p->p_media); $i++) {?>
                <div class="small-img-col">
                    <img src="<?=isset($p->p_media[$i]) ? $p->p_media[$i] : ImageManager::asset_img('shop/1.jpg')?>"
                        width="100%" class="small-img" alt="">
                </div>
                <?php }?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-12 description">
            <h6><?= $p->item_brand ?? 'Brand' ?>
            </h6>
            <h3 class="py-4"> <?= $p->p_title ?? 'Unknown' ?>
            </h3>
            <h2 class="price"><?=$p->get_money()->getAmount($p->p_compare_price)?>
            </h2>
            <select name="" id="" class="my-3 size">
                <option value="">Select size</option>
                <option value="">XL</option>
                <option value="">XXL</option>
                <option value="">Small</option>
                <option value="">Large</option>
            </select>
            <input type="number" value="1" class="quantity">
            <button class="buy-btn">Add To cart</button>
            <h4 class="mt-5 mb-5">Product Details</h4>
            <span>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Possimus, numquam ratione eveniet
                consequuntur sed, sunt, amet sequi explicabo praesentium quis animi odio ipsam culpa neque qui esse
                laborum accusamus dolore.
                Soluta nesciunt ab ratione, rem eos in exercitationem sint illum non accusamus natus, aspernatur
                amet possimus mollitia iure repellat doloremque voluptate a iste eveniet itaque officiis. Fugiat
                illo quia quibusdam.</span>

        </div>
        <?php endif; ?>
    </div>
</section>