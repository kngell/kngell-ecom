<?php declare(strict_types=1);
$this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('path', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id=main-site>
   <!-- Content -->
   <div class="container mt-4">
      <div class="content-404">
         <h1><b>OPPS!</b> Restricted access</h1>
         <p>Uh... So it looks like you brock something or you do not have permission to access this page.</p>
         <div class="button-group">
            <a href="<?='/home'?>" class="btn">Bring
               me back Home</a>&nbsp; <span>Or</span>&nbsp;
            <button type="button" class="btn">Please Loggin</button>
         </div>

      </div>
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
