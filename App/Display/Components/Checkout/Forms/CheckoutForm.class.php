<?php

declare(strict_types=1);
class CheckoutForm extends ClientFormBuilder implements ClientFormBuilderInterface
{
    private CheckoutForm $frm;

    public function __construct(private FormBuilderBlueprint $frmPrint, ?Object $repository = null, ?string $templateName = null)
    {
        $path = APP . 'Display' . DS . 'Components' . DS . 'Checkout' . DS . 'Templates' . DS . lcfirst(($templateName ?? $this::class) . 'Template.php');
        if (file_exists($path)) {
            $this->template = file_get_contents($path);
        }
        parent::__construct($repository);
    }

    public function createForm(string $action, ?object $dataRepository = null, ?object $callingController = null) : mixed
    {
        $this->frm = $this->form([
            'action' => $action,
            'class' => ['checkout-frm'],
            'id' => 'checkout-frm',
        ]);
        $btns = new ButtonsGroup($this->frm, $dataRepository);
        $this->template = str_replace('{{form_begin}}', $this->frm->begin(), $this->template);
        $this->template = str_replace('{{userInfos}}', (new UserInfos($this->frm, $dataRepository))->userInfos(), $this->template);
        $this->template = str_replace('{{shippingInfos}}', (new ShippingInfos($this->frm, $dataRepository))->shippingInfos(), $this->template);
        $this->template = str_replace('{{billiingInfos}}', (new BillingInfos($this->frm, $dataRepository))->billiingInfos(), $this->template);
        $this->template = str_replace('{{paiementInfos}}', (new PaiementInfos($this->frm, $dataRepository))->paiementInfos(), $this->template);
        $this->template = str_replace('{{buttons}}', $btns->buttonsGroup(), $this->template);
        $this->template = str_replace('{{buttonsSubmit}}', $btns->buttonsGroup(true), $this->template);
        $this->template = str_replace('{{form_end}}', $this->frm->end(), $this->template);
        return $this->template;
    }
}