<?php declare(strict_types=1);
$this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('css/learn/learn', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
   <!-- Content -->
   <div class="container k-pt-2 k-justify-center buttons">
      <div class="k-row k-justify-center">
         <button class="subscribe-button">subscribe</button>
         <button class="join-button">Join my channel</button>
         <button class="tweet-button">tweet</button>
      </div>

   </div>
   <hr>
   <div class="container k-pt-2 k-justify-center text">
      <p class="video-title">Talking Tech and AI with Google CEO Sundar Pichai!</p>
      <p class="video-stat">3.4M views &#183; 6 months ago</p>
      <p class="video-author">Marques Brownlee &#10003;</p>
      <p class="video-description">Talking tech and AI on the heels of Google I/O. Also a daily driver phone reveal from
         Google's CEO. Shoutout to Sundar!</p>
      <p class="apple-text">Shop early for the best selection of holiday favourites. <span class="shop-link">Shop now
            &#62;</span></p>
   </div>

   <!-- Fin Content -->
   <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('pathjs', 'js') ?? ''?>">
</script>
<?php $this->end();
