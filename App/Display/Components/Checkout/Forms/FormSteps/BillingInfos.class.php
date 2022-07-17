<?php

declare(strict_types=1);

class BillingInfos extends AbstractCheckoutformSteps implements CheckoutFormStepInterface
{
    private string $stepTitle = 'Billing Address';

    public function __construct(protected ?object $frm, protected ?CartSummary $summary, protected ?CollectionInterface $paths, protected ?ButtonsGroup $btns)
    {
        $this->frm->globalClasses([
            'wrapper' => ['radio-check', 'billing-address-header'],
        ]);
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

    protected function outputTemplate(string $template, string $dataTemplate) : string
    {
        $temp = '';
        $temp = str_replace('{{userCartSummary}}', $this->summary->display($this), $template);
        $temp = str_replace('{{data}}', $dataTemplate, $temp);
        $temp = str_replace('{{title}}', $this->titleTemplate($this->stepTitle), $temp);
        $temp = str_replace('{{discountCode}}', $this->discountCode(), $temp);
        $temp = str_replace('{{billingFrom}}', $this->billingform(), $temp);
        $temp = str_replace('{{buttons_group}}', $this->buttons(), $temp);
        return $temp;
    }

    protected function billingform() : string
    {
        $template = $this->paths->offsetGet('billingFormPath');
        $this->isFileexists($template);
        $template = file_get_contents($template);
        $template = str_replace('{{billingAddressRadio1}}', $this->frm->input([
            RadioType::class => ['name' => 'prefred_billing_addr', 'class' => ['radio__input', 'me-2']],
        ])->id('checkout-billing-address-id-1')
            ->value('1')
            ->spanClass(['radio__radio'])
            ->textClass(['radio__text'])
            ->Label('Same as shipping address')
            ->html(), $template);
        $template = str_replace('{{billingAddressRadio2}}', $this->frm->input([
            RadioType::class => ['name' => 'prefred_billing_addr', 'class' => ['radio__input', 'me-2']],
        ])->id('checkout-billing-address-id-2')
            ->value('2')
            ->spanClass(['radio__radio'])
            ->textClass(['radio__text'])
            ->Label('Use a different billing address')
            ->html(), $template);
        return $template;
    }
}