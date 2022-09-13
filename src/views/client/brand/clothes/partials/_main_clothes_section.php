<section class="head-promotions" id=head-promotions <?php if (isset($slider['image']) && is_array($slider['image'])):
    foreach ($slider['image'] as $image) :?> style="background-image: url(<?=str_replace('\\', '/', $image)?> )">
   <div class="container title">
      <h5 class="first-title"><?=strtoupper($slider['title'])?>
      </h5>
      <h1 class="second-title">
         <?php $title = explode('|', $slider['title']);
        $title = array_map('trim', $title); ?>
         <span class="title-left"><?=$title[0]?>
         </span>&nbsp;<span class="title-right"><?=$title[1]?></span>
      </h1>
      <?php $text = explode('|', $slider['text'])?>
      <p><?=$text[0]?> <br><?=$text[1]?>
      </p>
      <button><?=$slider['btn_text']?></button>
   </div>
   <?php endforeach; endif; ?>
</section>