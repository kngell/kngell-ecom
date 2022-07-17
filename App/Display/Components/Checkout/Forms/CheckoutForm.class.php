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
        list($paths, $shipping, $btns, $cartSummary, $pmtMode, $dataRepository) = $this->nestedObjects($dataRepository);
        $this->template = str_replace('{{form_begin}}', $this->frm->begin(), $this->template);
        $this->template = str_replace('{{userInfos}}', (new UserInfos($this->frm, $dataRepository, $btns, $cartSummary, $paths))->display(), $this->template);
        $this->template = str_replace('{{shippingInfos}}', (new ShippingInfos($this->frm, $cartSummary, $shipping, $paths, $btns))->display(), $this->template);
        $this->template = str_replace('{{billiingInfos}}', (new BillingInfos($this->frm, $cartSummary, $paths, $btns))->display(), $this->template);
        $this->template = str_replace('{{paiementInfos}}', (new PaiementInfos($this->frm, $cartSummary, $pmtMode, $paths, $btns))->display(), $this->template);
        $this->template = str_replace('{{form_end}}', $this->frm->end(), $this->template);
        $this->template = str_replace('{{formDiscount}}', $this->newform('discount-frm'), $this->template);
        return $this->template;
    }

    public function newform(string $id, string $action = '')
    {
        $this->frm->form([
            'action' => $action,
            'class' => [$id],
            'id' => $id,
        ]);
        $frmHtml = $this->frm->begin();
        $frmHtml .= $this->frm->end();
        return $frmHtml;
    }

    private function nestedObjects(?object $dataRepository = null) : array
    {
        $paths = $dataRepository->offsetGet('paths');
        $shipping = $dataRepository->offsetGet('shipping');
        $pmtMode = $dataRepository->offsetGet('pmtMode');
        $cartSummary = $dataRepository->offsetGet('cartSummary');
        $dataRepository = $this->cleanRepo($dataRepository);
        $btns = new ButtonsGroup($this->frm);
        return [$paths, $shipping, $btns, $cartSummary, $pmtMode, $dataRepository];
    }

    private function cleanRepo(?object $dataRepository = null) : object
    {
        $dataRepository->offsetUnset('paths');
        $dataRepository->offsetUnset('shipping');
        $dataRepository->offsetUnset('pmtMode');
        $dataRepository->offsetUnset('cartSummary');
        return $dataRepository;
    }
}