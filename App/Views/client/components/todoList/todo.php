<?php declare(strict_types=1);
$this->start('head'); ?>
<!-------Costum-------->
<link href="<?= $this->asset('css/components/todoList/todoList', 'css') ?? ''?>" rel="stylesheet" type="text/css">
<?php $this->end(); ?>
<?php $this->start('body'); ?>
<main id="main-site">
   <!-- Content -->

   <div class="container k-justify-center k-pt-5 k-pb-5" id="todo-element">
      <!-- Toto List -->
      <input id="toto-title" type="text" />
      <input type="date" class="date" id="date-picker">
      <button id="button">Press Me</button>
      <div class="toto-list" id="todo-list">

      </div>

   </div>
   <!-- Fin Content -->
   <input type="hidden" id="ip_address" style="display:none" value="<?=H_visitors::getIP()?>">
</main>
<?php $this->end(); ?>
<?php $this->start('footer') ?>
<!----------custom--------->
<script type="text/javascript" src="<?= $this->asset('js/components/todoList/todoList', 'js') ?? ''?>">
</script>
<?php $this->end();