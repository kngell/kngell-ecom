<?php

declare(strict_types=1);

class CheckoutPage extends AbstractCheckout implements DisplayPagesInterface
{
    public function __construct(CollectionInterface|Closure $userCart, CollectionInterface|Closure $shippingClass, CollectionInterface|Closure $pmtMode, FormBuilder $frm, ?Customer $customer, ?CreditCardPage $creditCard = null)
    {
        list($userCart, $shippingClass, $pmtMode) = $this->invoke([$userCart, $shippingClass, $pmtMode]);
        parent::__construct($userCart, $shippingClass, $pmtMode, $frm, (new CheckoutPartials())->paths(), $customer, $creditCard);
        $this->userCheckoutSesstion();
    }

    public function displayAll(): array
    {
        return [
            'progressBar' => $this->getTemplate('progressBarPath'),
            'checkoutForm' => $this->checkoutForm(),
            'modals' => implode('', $this->modals()),
        ];
    }

    protected function checkoutForm() :  string
    {
        $this->frm->form([
            'action' => '#',
            'class' => ['checkout-frm'],
            'id' => 'checkout-frm',
        ])->globalClasses([
            'wrapper' => [],
            'input' => ['input-box__input'],
            'label' => ['input-box__label'],
        ]);
        $template = $this->getTemplate('checkoutFormTemplatePath');
        $template = str_replace('{{form_begin}}', $this->frm->begin(), $template);
        $template = str_replace('{{userInfos}}', (new UserInfos($this->params()))->display(), $template);
        $template = str_replace('{{shippingInfos}}', (new ShippingInfos($this->params()))->display(), $template);
        $template = str_replace('{{billiingInfos}}', (new BillingInfos($this->params()))->display(), $template);
        $template = str_replace('{{paiementInfos}}', (new PaiementInfos($this->params()))->display(), $template);
        $template = str_replace('{{creditCard}}', $this->creditcardModal(), $template);
        $template = str_replace('{{form_end}}', $this->frm->end(), $template);
        $template = str_replace('{{formDiscount}}', $this->discountForm('discount-frm', '#', $this->frm), $template);

        return $template;
    }

    protected function modals() : array
    {
        $this->frm->globalClasses([
            'wrapper' => [],
        ]);
        return [
            $this->addressBookModal(),
            $this->addAddressModal(),
            $this->changeEmailModal(),
            $this->changeShippingModeModal(),
        ];
    }

    protected function addressBookModal() : string
    {
        $this->frm->form([
            'action' => '#',
            'id' => 'change-address-frm',
            'class' => ['change-address-frm'],
        ]);
        $template = $this->getTemplate('userAddressModalPath');
        $template = str_replace('{{addressBookContent}}', $this->addressBookContent(), $template);
        return $template;
    }

    protected function addAddressModal() : string
    {
        $template = $this->getTemplate('addAddressModalPath');
        $this->frm->form([
            'action' => '',
            'id' => 'add-address-frm',
            'class' => ['add-address-frm'],
        ]);
        $template = str_replace('{{form_begin}}', $this->frm->begin(), $template);
        $template = str_replace('{{addAddressContent}}', $this->AddAdressContent(), $template);
        $template = str_replace('{{form_end}}', $this->frm->end(), $template);
        return $template;
    }

    protected function changeEmailModal() : string
    {
        $this->frm->form([
            'action' => '#',
            'class' => ['change-email-frm'],
            'id' => 'change-email-frm',
        ]);
        $template = $this->getTemplate('changeEmailModalPath');
        $template = str_replace('{{changeEmailFormTemplate}}', $this->changeEmailForm($this->frm), $template);
        return $template;
    }

    protected function changeShippingModeModal() : string
    {
        $this->frm->form([
            'action' => '#',
            'class' => ['shipping-select-frm'],
            'id' => 'shipping-select-frm',
        ]);
        $template = $this->getTemplate('changeShippingModalPath');
        $template = str_replace('{{changeShippingModeform}}', $this->changeShippingFrom(), $template);
        return $template;
    }

    protected function creditcardModal() : string
    {
        $template = $this->getTemplate('creditCardModalPath');
        $template = str_replace('{{price}}', $this->cartSummary->getTTC()->formatTo('fr_FR'), $template);
        $template = str_replace('{{creditCardTemplate}}', $this->creditCardContent(), $template); //$this->creditCard->creditCard() //$this->creditCardContent()
        return $template;
    }
}