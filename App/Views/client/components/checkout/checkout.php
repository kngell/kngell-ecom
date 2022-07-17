<?php declare(strict_types=1);
$this->start('head'); ?>
<!-------Costum-------->
<script src="https://js.stripe.com/v3/"></script>
<link href="<?= $this->asset('css/components/checkout/checkout', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
   <!-- Content -->
   <div class="page-content">
      <div class="container k-justify-center" id="checkout-element">
         <!-- progress Bar -->
         <?= $progressBar ?? ''?>
         <!-- Form elements & content -->
         <section id="checkout-content" class="checkout-content">
            <?= $checkoutForm ?? ''?>
         </section>
         <!-- extra elements -->
         <section id="extras-features">
            <?= $creditCardModal ?? ''?>
            <?= $defaultDeliveryAdressModal ?? ''?>
         </section>
      </div>
   </div>
   <!-- Fin Content -->
   <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/components/checkout/checkout', 'js') ?? ''?>">
</script>
<?php $this->end();