<?php

declare(strict_types=1);

class CheckoutPage extends AbstractCheckout implements DisplayPagesInterface
{
    private string $stripKey = STRIPE_KEY_SECRET;
    private CartSummary $cartSummary;

    public function __construct(CollectionInterface|Closure $userCart, CollectionInterface|Closure $shippingClass, CollectionInterface|Closure $pmtMode, CheckoutForm $frm)
    {
        list($userCart, $shippingClass, $pmtMode) = $this->invoke([$userCart, $shippingClass, $pmtMode]);
        parent::__construct($userCart, $shippingClass, $pmtMode, $frm, (new CheckoutPartials())->paths());
        $this->frm->globalClasses([
            'wrapper' => [],
            'input' => ['input-box__input'],
            'label' => ['input-box__label'],
        ]);
    }

    public function displayAll(): array
    {
        $this->cartSummary = (new CartSummary($this->userCart, $this->paths));
        $this->userCart->offsetSet('paths', $this->paths);
        $this->userCart->offsetSet('shipping', $this->shippingClass);
        $this->userCart->offsetSet('pmtMode', $this->pmtMode);
        $this->userCart->offsetSet('cartSummary', $this->cartSummary);
        return [
            'progressBar' => $this->progressBar(),
            'checkoutForm' => $this->frm->createForm('', $this->userCart),
            'creditCardModal' => $this->creditcardModal(),
            'defaultDeliveryAdressModal' => $this->defaultDeliveryAddress(),
        ];
    }

    private function defaultDeliveryAddress() : string
    {
        $template = $this->paths->offsetGet('deliveryAddressModalPath');
        if (file_exists($template)) {
            $template = file_get_contents($template);
            $this->frm->form([
                'action' => '',
                'id' => 'delivery-address-frm',
                'class' => ['delivery-address-frm'],
                'enctype' => 'multipart/form-data',
            ]);
            $template = str_replace('{{form_begin}}', $this->frm->begin('delivery-address-frm'), $template);
            $template = str_replace('{{deliveryAddress}}', $this->deliveryAdressTemplate(), $template);
            $template = str_replace('{{form_end}}', $this->frm->end(), $template);
        }
        return $template;
    }

    private function deliveryAdressTemplate() : string
    {
        $uDeliveryAdress = $this->paths->offsetGet('deliveryAddressPath');

        if (file_exists($uDeliveryAdress)) {
            $uDeliveryAdress = file_get_contents($uDeliveryAdress);
            $uDeliveryAdress = str_replace('{{pays}}', $this->frm->input([
                SelectType::class => ['name' => 'pays', 'class' => ['input-box__select', 'select_country']],
            ])->noLabel()->id('pays')->req()->placeholder(' ')->html(), $uDeliveryAdress);

            $uDeliveryAdress = str_replace('{{address1}}', $this->frm->input([
                TextType::class => ['name' => 'address1'],
            ])->Label('Adresse ligne 1')->id('address1')->req()->placeholder(' ')->html(), $uDeliveryAdress);

            $uDeliveryAdress = str_replace('{{address2}}', $this->frm->input([
                TextType::class => ['name' => 'address2'],
            ])->Label('Adresse ligne 2')->id('address2')->placeholder(' ')->html(), $uDeliveryAdress);

            $uDeliveryAdress = str_replace('{{ville}}', $this->frm->input([
                TextType::class => ['name' => 'ville'],
            ])->Label('Ville')->id('ville')->placeholder(' ')->html(), $uDeliveryAdress);

            $uDeliveryAdress = str_replace('{{region}}', $this->frm->input([
                TextType::class => ['name' => 'region'],
            ])->Label('Région/Etat')->id('region')->placeholder(' ')->html(), $uDeliveryAdress);

            $uDeliveryAdress = str_replace('{{zipCode}}', $this->frm->input([
                TextType::class => ['name' => 'zip_code'],
            ])->Label('Code Postal')->id('zip_code')->req()->placeholder(' ')->html(), $uDeliveryAdress);

            $uDeliveryAdress = str_replace('{{u_comment}}', $this->frm->input([
                TextAreaType::class => ['name' => 'u_comment', 'class' => ['input-box__textarea']],
            ])->Label('Commentaires, notes ...')->id('u_comment')->attr(['form' => 'user-ckeckout-frm'])->rows(2)->LabelClass(['input-box__label'])->placeholder(' ')->html(), $uDeliveryAdress);

            $uDeliveryAdress = str_replace('{{checkout-remember-me}}', $this->frm->input([
                CheckBoxType::class => ['name' => 'checkout-remember-me'],
            ])->Label('Sauvegarder ces informations pour la prochaine fois')->id('checkout-remember-me')->class(['checkbox__input'])->spanClass(['checkbox__box'])->LabelClass(['checkbox'])->wrapperClass(['mt-2'])->req()->placeholder(' ')->html(), $uDeliveryAdress);

            return $uDeliveryAdress;
        }
    }

    private function creditcardModal() : string
    {
        $template = $this->paths->offsetGet('creditCardModalPath');
        if (file_exists($template)) {
            $template = file_get_contents($template);
            $this->frm->form([
                'action' => '',
                'id' => 'credit_card-frm',
                'class' => ['credit_card-frm'],
                'enctype' => 'multipart/form-data',
            ]);
            $template = str_replace('{{price}}', $this->cartSummary->getTTC(), $template);
            $template = str_replace('{{form_begin}}', $this->frm->begin('credit_card-frm'), $template);
            $template = str_replace('{{creditCardTemplate}}', $this->creditCardTemplate(), $template);
            $template = str_replace('{{form_end}}', $this->frm->end(), $template);
        }
        return $template;
    }

    private function creditCardTemplate() : string
    {
        $template = $this->paths->offsetGet('creditCardTemplatePath');
        if (!file_exists($template)) {
            throw new BaseException('No Credit card template found!');
        }
        $template = file_get_contents($template);
        $template = str_replace('{{stripeKey}}', $this->stripKey, $template);
        $template = str_replace('{{cc_image}}', ImageManager::asset_img('visa.png'), $template);
        $template = str_replace('{{cardHolder}}', $this->frm->input([
            TextType::class => ['name' => 'card_holder', 'class' => ['card_holder']],
        ])->id('card_holder')->Label('Card Holder:')->placeholder(' ')->html(), $template);
        return $template;
    }

    private function progressBar() : string
    {
        $template = $this->paths->offsetGet('progressBarPath');
        if (file_exists($template)) {
            return file_get_contents($template);
        }
        return '';
    }
}