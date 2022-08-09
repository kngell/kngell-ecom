<?php

declare(strict_types=1);

class PaiementInfos extends AbstractFormSteps implements CheckoutFormStepInterface
{
    protected ?CollectionInterface $pmtMode;
    protected ?CollectionInterface $shippingClass;
    private string $title = 'Paiement Informations';
    private string $btnNextText = 'Place Order';

    public function __construct(array $params = [])
    {
        $this->properties($params);
    }

    public function display() : string
    {
        return $this->outputTemplate($this->getTemplate('mainBillingPath'), $this->getTemplate('paiementData'));
    }

    private function outputTemplate(string $template = '', string $dataTemplate = '') : string
    {
        $temp = '';
        /** @var CustomerEntity */
        $en = $this->customer->getEntity();
        list('name' => $method, 'price' => $price) = $this->shippingMethod($this->shippingClass);
        $temp = str_replace('{{userCartSummary}}', $this->summary->display($this), $template);
        $temp = str_replace('{{discountCode}}', $this->discountCode(), $temp);
        $temp = str_replace('{{data}}', $dataTemplate, $temp);
        $temp = str_replace('{{title}}', $this->titleTemplate($this->title), $temp);
        $temp = str_replace('{{contact_email}}', $en->isInitialized('email') ? $en->getEmail() : '', $temp);
        $temp = str_replace('{{address_de_livraion}}', $this->customerAddress(1), $temp);
        $temp = str_replace('{{shipping_mode}}', $method, $temp);
        $temp = str_replace('{{shipping_price}}', $this->money->getFormatedAmount($price, 2), $temp);
        $temp = str_replace('{{addresse_de_facturation}}', $this->customerAddress(1), $temp);
        $temp = str_replace('{{paiementForm}}', $this->form(), $temp);
        $temp = str_replace('{{buttons_group}}', $this->buttons($this->btnNextText), $temp);
        return $temp;
    }

    private function form() : string
    {
        $i = 0;
        $html = '';
        $temp = $this->getTemplate('paiementFormPath');
        $ccIcon = $this->getTemplate('creditCardIconsPath');
        if ($this->pmtMode->count() > 0) {
            foreach ($this->pmtMode->all() as $mode) {
                if ($mode->status == 'on') {
                    $default = $mode->default == 1 ? true : false;
                    $template = str_replace('{{paiement_mode}}', $this->frm->input([
                        RadioType::class => ['name' => 'plate_form', 'class' => ['radio__input', 'me-2']],
                    ])->id('plate_form' . $i)
                        ->spanClass(['radio__radio'])
                        ->textClass(['radio__text'])
                        ->label($mode->pm_name)
                        ->checked($i == 0 ? $default : false)
                        ->wrapperClass(['radio-check__wrapper'])
                        ->labelClass(['radio'])
                        ->value($mode->pm_id)
                        ->html(), $temp);
                    $template = str_replace('{{CreditCarIcons}}', $mode->pm_name == 'Credit Card' ? $ccIcon : '', $template);
                    $html .= $template;
                    $i++;
                }
            }
        }
        return $html;
    }
}