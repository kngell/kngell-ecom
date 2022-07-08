<?php

declare(strict_types=1);

class PaiementInfos extends AbstractCheckout implements CheckoutFormStepInterface
{
    public function __construct(protected ?object $frm, protected ?string $summary, protected ?CollectionInterface $paths = null, protected ?ButtonsGroup $btns = null)
    {
    }

    public function display() : string
    {
        $mainTemplate = $this->paths->offsetGet('mainBillingPath');
        $shippingData = $this->paths->offsetGet('billingData');
        if ((!file_exists($mainTemplate) || !file_exists($shippingData))) {
            throw new BaseException('Files Not found!', 1);
        }
        return $this->outputTemplate(file_get_contents($mainTemplate), file_get_contents($shippingData));
    }

    private function outputTemplate(string $template = '', string $dataTemplate = '') : string
    {
        $temp = '';
        // $temp = str_replace('{{userCartSummary}}', $this->summary, $template);
        // $temp = str_replace('{{discountCode}}', $this->discount->createForm('', $this), $temp);
        // $temp = str_replace('{{billing_data}}', $dataTemplate, $temp);
        // $temp = str_replace('{{billingTitle}}', $this->titleTemplate('Billing Address'), $temp);
        // $temp = str_replace('{{billingFrom}}', $this->billingform(), $temp);
        // $temp = str_replace('{{buttonsRight}}', $this->btns->buttonsGroup('next'), $temp);
        // $temp = str_replace('{{buttonsLeft}}', $this->btns->buttonsGroup('prev'), $temp);
        return $temp;
    }
}