<?php

declare(strict_types=1);

class BillingInfos extends AbstractFormSteps implements CheckoutFormStepInterface
{
    private string $stepTitle = 'Billing Address';

    public function __construct(array $params)
    {
        parent::__construct($params);
    }

    public function display() : string
    {
        $mainTemplate = $this->getTemplate('mainBillingPath');
        $shippingData = $this->getTemplate('billingData');

        return $this->outputTemplate($mainTemplate, $shippingData);
    }

    protected function outputTemplate(string $template, string $dataTemplate) : string
    {
        $temp = '';
        list('name' => $method, 'price' => $price) = $this->shippingMethod($this->shippingClass);
        $temp = str_replace('{{userCartSummary}}', $this->summary->display($this), $template);
        $temp = str_replace('{{data}}', $dataTemplate, $temp);
        $temp = str_replace('{{title}}', $this->titleTemplate($this->stepTitle), $temp);
        $temp = str_replace('{{contact_email}}', $this->customerEntity->isInitialized('email') ? $this->customerEntity->getEmail() : '', $temp);
        $temp = str_replace('{{address_de_livraion}}', $this->customerAddress(1), $temp);
        $temp = str_replace('{{shipping_mode}}', $method, $temp);
        $temp = str_replace('{{shipping_price}}', $this->money->getFormatedAmount($price, 2), $temp);
        $temp = str_replace('{{discountCode}}', $this->discountCode(), $temp);
        $temp = str_replace('{{billingFrom}}', $this->billingform(), $temp);
        $temp = str_replace('{{buttons_group}}', $this->buttons(), $temp);

        return $temp;
    }

    protected function billingform() : string
    {
        $this->frm->globalClasses([
            'wrapper' => ['radio-check', 'billing-address-header'],
        ]);
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
            ->wrapperClass(['radio-check__wrapper'])
            ->labelClass(['radio'])
            ->checked(true)
            ->html(), $template);
        $template = str_replace('{{billingAddressRadio2}}', $this->frm->input([
            RadioType::class => ['name' => 'prefred_billing_addr', 'class' => ['radio__input', 'me-2']],
        ])->id('checkout-billing-address-id-2')
            ->value('2')
            ->spanClass(['radio__radio'])
            ->textClass(['radio__text'])
            ->Label('Use a different billing address')
            ->wrapperClass(['radio-check__wrapper'])
            ->labelClass(['radio'])
            ->html(), $template);
        $this->frm->globalClasses([
            'wrapper' => [],
        ]);

        return $template;
    }
}
