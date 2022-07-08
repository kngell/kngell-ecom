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
        list($paths, $shipping, $btns, $cartSummary, $dataRepository) = $this->nestedObjects($dataRepository);
        $this->template = str_replace('{{form_begin}}', $this->frm->begin(), $this->template);
        $this->template = str_replace('{{userInfos}}', (new UserInfos($this->frm, $dataRepository, $btns, $cartSummary, $paths))->display(), $this->template);
        $this->template = str_replace('{{shippingInfos}}', (new ShippingInfos($this->frm, $cartSummary, $shipping, $paths, $btns))->display(), $this->template);
        $this->template = str_replace('{{billiingInfos}}', (new BillingInfos($this->frm, $cartSummary, $paths, $btns))->display(), $this->template);
        $this->template = str_replace('{{paiementInfos}}', (new PaiementInfos($this->frm, $cartSummary, $paths, $btns))->display(), $this->template);
        $this->template = str_replace('{{form_end}}', $this->frm->end(), $this->template);
        $this->template = str_replace('{{formDiscount}}', $this->formDiscount(), $this->template);
        return $this->template;
    }

    private function nestedObjects(?object $dataRepository = null) : array
    {
        $paths = $dataRepository->offsetGet('paths');
        $shipping = $dataRepository->offsetGet('shipping');
        $dataRepository->offsetUnset('paths');
        $dataRepository->offsetUnset('shipping');
        $btns = new ButtonsGroup($this->frm, $dataRepository);
        $cartSummary = (new CartSummary($dataRepository, $paths))->userCartSummary();
        return [$paths, $shipping, $btns, $cartSummary, $dataRepository];
    }

    private function formDiscount() : string
    {
        $this->frm->form([
            'action' => '',
            'class' => ['discount-frm'],
            'id' => 'discount-frm',
        ]);
        $frmHtml = $this->frm->begin();
        $frmHtml .= $this->frm->end();
        return $frmHtml;
    }
}