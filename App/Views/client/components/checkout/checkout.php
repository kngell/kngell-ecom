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
            <div class="modals">
               <?= $modals ?? ''?>
            </div>
            <div class="forms-elements">
               <?= $forms_elements ?? ''?>
            </div>
         </section>
      </div>
   </div>
   <!-- Fin Content -->
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/components/checkout/checkout', 'js') ?? ''?>" defer>
</script>
<?php $this->end();
