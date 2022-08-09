<?php declare(strict_types=1);
$this->start('head'); ?>
<!-------Accueil-------->
<link href="<?= $this->asset('css/brand/phones/shoppingCart/shoppingCart', 'css') ?? ''?>" rel="stylesheet"
   type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<!-- Start Main -->
<main id="main-site">
   <!-- Shoping cart  -->
   <?= $shoppingCart ?? ''?>
   <!-- !Shpoping cart -->
   <!-- Wishlist  -->
   <?= $whislist ?? ''?>
   <!-- !Wishlist -->
   <!-- New Phones -->
   <?= $new_products ?? ''?>
   <!-- End New Phones -->
   <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<!-- End  Main -->

<?php $this->end(); ?>
<?php $this->start('footer')?>
<!-- Html visitors -->
<script type="text/javascript" src="<?= $this->asset('js/custom/client/home/cart/cart', 'js') ?? ''?>">
</script>
<?php $this->end();