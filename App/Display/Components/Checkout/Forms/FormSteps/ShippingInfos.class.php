<?php

declare(strict_types=1);

class ShippingInfos extends AbstractFormSteps implements CheckoutFormStepInterface
{
    protected ?CollectionInterface $shippingClass;
    private string $title = 'Shipping Method';

    public function __construct(array $params = [])
    {
        $this->properties($params);
    }

    public function display() : string
    {
        return $this->outputTemplate($this->getTemplate('mainShippingPath'), $this->getTemplate('shippingData'), $this->shippingClass);
    }

    private function outputTemplate(string $template = '', string $dataTemplate = '', ?Object $shippingClass = null) : string
    {
        $temp = '';
        /** @var CustomerEntity */
        $en = $this->customer->getEntity();
        if (!is_null($shippingClass) && $shippingClass->count() > 0) {
            $temp = str_replace('{{userCartSummary}}', $this->summary->display($this), $template);
            $temp = str_replace('{{discountCode}}', $this->discountCode(), $temp);
            $temp = str_replace('{{data}}', $dataTemplate, $temp);
            $temp = str_replace('{{title}}', $this->titleTemplate($this->title), $temp);
            $temp = str_replace('{{contact_email}}', $en->isInitialized('email') ? $en->getEmail() : '', $temp);
            $temp = str_replace('{{address_de_livraion}}', $this->customerAddress(1), $temp);
            $temp = str_replace('{{form_shipping_method}}', $this->shippingform($shippingClass), $temp);
            $temp = str_replace('{{buttons_group}}', $this->buttons(), $temp);
        }
        return $temp;
    }
}