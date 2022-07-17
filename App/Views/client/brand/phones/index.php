<?php declare(strict_types=1);
$this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('css/brand/phones/home', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<!-- Start Main -->
<main id="main-site">
   <div class="page-content">
      <!-- Owl carousel -->
      <?= $bannerArea ?? ''?>
      <!-- End Owl carousel -->

      <!-- Top Sales -->
      <?= $topSales ?? ''?>
      <!-- End top Sales -->

      <!-- Special price -->
      <?= $specialPrice ?? ''?>
      <!-- End Special price -->

      <!-- Banner Adds -->
      <?= $bannerAdds ?? ''?>
      <!-- End Banner Adds -->

      <!-- New Phones -->
      <?= $newProducts ?? ''?>
      <!-- End New Phones -->

      <!-- Blog -->
      <?= $blogArea ?? ''?>
      <!-- End blog -->
   </div>
   <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<!-- End  Main -->
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/brand/phones/home', 'js') ?? ''?>">
</script>
<?php $this->end();