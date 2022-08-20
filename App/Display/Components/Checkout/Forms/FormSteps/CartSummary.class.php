<?php

declare(strict_types=1);

use Brick\Money\Money;

class CartSummary extends AbstractFormSteps implements CheckoutFormStepInterface
{
    use CartSummaryTrait;
    private array $taxesProducts = [];
    private Money $shippingAmount;
    private string $cartSummary = '';
    private string $cardContent = '';

    public function __construct(?CollectionInterface $obj, ?CollectionInterface $shippingClass = null, ?MoneyManager $money = null, ?CollectionInterface $paths = null)
    {
        parent::__construct([
            'obj' => $obj,
            'shippingClass' => $shippingClass,
            'money' => $money,
            'paths' => $paths,
        ]);
        $this->shippingAmount = $this->money->getCustomAmt('0', 2);
        $this->cartSummary();
    }

    public function display(?object $step = null) : string
    {
        return $this->cartSummary;
    }

    protected function cartSummary(?object $step = null) : void
    {
        $uCartSummary = $this->getTemplate('cartSummaryPath');
        $this->cardContent = empty($this->cardContent) ? $this->cartSummaryContent() : $this->cardContent;
        $uCartSummary = str_replace('{{cartSummaryContent}}', $this->cardContent, $uCartSummary);
        $this->cardSubTotal = empty($this->cardSubTotal) ? $this->cartSummaryTotal() : $this->cardSubTotal;
        $uCartSummary = str_replace('{{CartSummaryTotal}}', $this->cardSubTotal, $uCartSummary);
        $uCartSummary = str_replace('{{button}}', $this->cartSummaryButton($step), $uCartSummary);
        $this->cartSummary = $uCartSummary;
        $this->totalItems = $this->obj->count();
    }

    protected function cartSummaryTotal() : string
    {
        $this->HT = $this->totalHT($this->obj);
        $this->finalTaxes = $this->calcTaxes($this->taxesProducts);
        $taxeTemplate = $this->getTemplate('texesPath');
        list($taxeHtml, $totalTaxes) = $this->taxesHtmlAndtotal($this->finalTaxes, $taxeTemplate);
        $uCartSummaryTotal = $this->getTemplate('cartSummaryTotalPath');
        $uCartSummaryTotal = str_replace('{{totalHT}}', $this->HT->formatTo('fr_FR') ?? '', $uCartSummaryTotal);
        $uCartSummaryTotal = str_replace('{{reduction}}', $reduction ?? '', $uCartSummaryTotal);
        $uCartSummaryTotal = str_replace('{{taxes}}', $taxeHtml ?? '', $uCartSummaryTotal);
        $uCartSummaryTotal = $this->totalShipping($uCartSummaryTotal);
        $this->TTC = $this->HT->plus($totalTaxes)->plus($this->shippingAmount);
        $uCartSummaryTotal = str_replace('{{totalTTC}}', $this->TTC->formatTo('fr_FR') ?? '', $uCartSummaryTotal);

        return $uCartSummaryTotal;
    }

    private function cartSummaryButton(?object $step = null) : string
    {
        if (!is_null($step) && $step::class === 'PaiementInfos') {
            return '<div class="button-pay"><button type="button" class="btn btn-pay">Complete Order</button></div>';
        }
        return '';
    }

    private function cartSummaryContent() : string
    {
        $template = '';
        $temp = $this->getTemplate('cartSummaryContentPath');
        $this->taxesProducts = [];
        foreach ($this->obj as $product) {
            if ($product->cart_type == 'cart') {
                $HT = $product->regular_price * $product->item_qty;
                $this->taxesProducts[] = $this->filterTaxe($HT, $product, $this->getAllTaxes($this->obj), $product->item_qty);
                $uCartSummaryContent = str_replace('{{image}}', $this->media($product), $temp);
                $uCartSummaryContent = str_replace('{{Quantity}}', strval($product->item_qty), $uCartSummaryContent);
                $uCartSummaryContent = str_replace('{{title}}', $product->title ?? '', $uCartSummaryContent);
                $uCartSummaryContent = str_replace('{{color}}', $product->color ?? '', $uCartSummaryContent);
                $sep = isset($product->p_color) && isset($product->p_size);
                $uCartSummaryContent = str_replace('{{separator}}', $sep && ($product->color != null || $product->p_size != null) ? ' / ' : '', $uCartSummaryContent);
                $uCartSummaryContent = str_replace('{{size}}', $product->size ?? '', $uCartSummaryContent);
                $uCartSummaryContent = str_replace('{{price}}', strval($this->money->getFormatedAmount(strval($HT))) ?? '', $uCartSummaryContent);
                $template .= $uCartSummaryContent;
            }
        }
        return $template;
    }

    private function totalShipping(string $template) : string
    {
        $temp = '';
        /** @var CollectionInterface */
        $shippingMode = !empty($this->userItems) ? $this->getShippingClassObj($this->shippingClass) : null;
        if (!is_null($shippingMode)) {
            $temp = str_replace('{{shipping}}', $this->totalShippingContent($shippingMode), $template);
        }
        return $temp == '' ? str_replace('{{shipping}}', '', $template) : $temp;
    }

    private function totalShippingContent(object $shippingMode) : string
    {
        $template = $this->getTemplate('totalShippingPath');
        $template = str_replace('{{title}}', $shippingMode->sh_name, $template);
        $template = str_replace('{{sh_amount}}', strval($this->money->getFormatedAmount(strval($shippingMode->price))) ?? '', $template);
        $this->shippingAmount = $this->money->getCustomAmt(strval($shippingMode->price), 2);
        return $template;
    }
}