<?php declare(strict_types=1);
if (isset($this->pmt_getaway) && $this->pmt_getaway->count() > 0) :?>
<?php foreach ($this->pmt_getaway->get_results() as $pmt_getaway) :?>
<?php if ($pmt_getaway->status == 'on'):?>
<?php $form->setModel($pmt_getaway)->wrapperClass('radio-check__wrapper')->fieldCommonclass(['fieldclass' => 'radio__input', 'labelClass' => 'radio']); ?>
<div class="payment-gateway">
   <div class="radio-check payment-gateway-header">
      <?php $checked = ($pmt_getaway->pm_name == 'Credit Card') ? true : false; ?>
      <?= $form->radio('pm_name')->id('pm_name')->radioType()->value(strval($pmt_getaway->pmID))->spanClass('radio__radio')->textClass('radio__text')->label($pmt_getaway->pm_name)->checked($checked)?>

      <?php if ($pmt_getaway->pm_name == 'Credit Card') :?>
      <div class="brand-icons">
         <span><a href="#" class="text-highlight">Change</a></span>
         <span class="payment-icon payment-icon-visa">
         </span>
         <span class="payment-icon payment-icon-master">
         </span>
         <span class="payment-icon payment-icon-american-express">
         </span>
         <span class="payment-icon payment-icon-discover">
         </span>
      </div>
      <?php endif; ?>
   </div>

</div>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>