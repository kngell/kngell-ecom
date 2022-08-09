<?php

declare(strict_types=1);

abstract class AbstractCreditCardPage
{
    use DisplayTraits;
    use DisplayFormElementTrait;

    protected ?FormBuilder $frm;
    protected ?CollectionInterface $paths;
    protected ?Customer $customer;
    protected ?DateTimeManager $dm;
    protected string $stripKey = STRIPE_KEY_PUBLIC;

    public function __construct(?CreditCardPaths $paths = null, ?Customer $customer = null, ?FormBuilder $frm = null, ?DateTimeManager $dm = null)
    {
        $this->frm = $frm;
        $this->paths = $paths->Paths();
        $this->customer = $this->customer($customer);
        $this->dm = $dm;
    }

    protected function creditCardForm() : string
    {
        $template = $this->getTemplate('creditCardFormPath');

        $this->frm->globalClasses([
            'wrapper' => [],
            'input' => ['input-box__input'],
            'label' => ['input-box__label'],
        ]);

        $template = str_replace('{{stripeKey}}', $this->frm->input([
            HiddenType::class => ['name' => 'stripe_key'],
        ])->noLabel()->noWrapper()->id('stripe_key')->value($this->stripKey)->html(), $template);

        $template = str_replace('{{card_error}}', $this->frm->input([
            DivType::class => ['class' => ['card_error']],
        ])->noLabel()->noWrapper()->id('card_error')->html(), $template);

        $template = str_replace('{{card_number}}', $this->frm->input([
            DivType::class => ['class' => []],
        ])->label('numero de carte:')->placeholder(' ')->id('cc_number')->html(), $template);

        $template = str_replace('{{card_holder}}', $this->frm->input([
            TextType::class => ['name' => 'cc_holder', 'class' => ['custom-font']],
        ])->label('nom sur la carte:')->placeholder(' ')->id('cc_holder')->html(), $template);

        $template = str_replace('{{card_expiry}}', $this->frm->input([
            DivType::class => ['class' => ['form-control']],
        ])->label('Exp. mm/yy:')->placeholder(' ')->id('cc_Expiry')->html(), $template);

        $template = str_replace('{{ccv}}', $this->frm->input([
            DivType::class => ['class' => ['form-control']],
        ])->label('cvv:')->placeholder(' ')->id('cc_cvv')->html(), $template);

        $template = str_replace('{{button}}', $this->frm->input([
            ButtonType::class => ['type' => 'submit', 'class' => ['button', 'submit-btn']],
        ])->noWrapper()->content('Pay')->id('complete-order')->attr(['disabled' => true])->html(), $template);

        return $template;
    }
}