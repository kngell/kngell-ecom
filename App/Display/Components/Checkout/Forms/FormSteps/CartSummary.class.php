<?php

declare(strict_types=1);

use Brick\Money\Money;

class CartSummary extends AbstractCheckout
{
    private MoneyManager $money;
    private array $taxesProducts = [];

    public function __construct(private ?object $obj, private ?CollectionInterface $paths = null)
    {
        $this->money = MoneyManager::getInstance();
    }

    public function userCartSummary() : string
    {
        $uCartSummary = $this->paths->offsetGet('cartSummaryPath');
        $this->isFileexists($uCartSummary);
        $uCartSummary = file_get_contents($uCartSummary);
        $uCartSummary = str_replace('{{cartSummaryContent}}', $this->cartSummaryContent(), $uCartSummary);
        $uCartSummary = str_replace('{{CartSummaryTotal}}', $this->cartSummaryTotal(), $uCartSummary);
        return $uCartSummary;
    }

    private function cartSummaryContent() : string
    {
        $temp = $this->paths->offsetGet('cartSummaryContentPath');
        $this->isFileexists($temp);
        $temp = file_get_contents($temp);
        $template = '';
        foreach ($this->obj as $product) {
            if ($product->cart_type == 'cart') {
                $HT = $product->regular_price * $product->item_qty;
                $this->taxesProducts[] = $this->filterTaxe($HT, $product, $this->getAllTaxes());
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

    private function cartSummaryTotal() : string
    {
        $totalHT = $this->totalHT();
        list($taxeHtml, $totalTaxes) = $this->calcTaxesHtml();
        $uCartSummaryTotal = $this->paths->offsetGet('cartSummaryTotalPath');
        $this->isFileexists($uCartSummaryTotal);
        $uCartSummaryTotal = file_get_contents($uCartSummaryTotal);
        $uCartSummaryTotal = str_replace('{{totalHT}}', $totalHT->formatTo('fr_FR') ?? '', $uCartSummaryTotal);
        $uCartSummaryTotal = str_replace('{{reduction}}', $reduction ?? '', $uCartSummaryTotal);
        $uCartSummaryTotal = str_replace('{{taxes}}', $taxeHtml ?? '', $uCartSummaryTotal);
        $uCartSummaryTotal = str_replace('{{totalTTC}}', $totalHT->plus($totalTaxes)->formatTo('fr_FR') ?? '', $uCartSummaryTotal);
        return $uCartSummaryTotal;
    }

    private function filterTaxe(mixed $HT, object $product, CollectionInterface $taxes) : object
    {
        $productTaxes = $taxes->filter(fn ($taxe) => $product->cat_id == $taxe->tr_catID);
        return (object) ['item' => $product->item_id, 'taxes' => $productTaxes, 'amount' => $HT];
    }

    private function calcTaxesHtml() : array
    {
        $finalTaxes = [];
        foreach ($this->taxesProducts as $taxeParams) {
            foreach ($taxeParams->taxes->all() as $tax) {
                if ($tax->status == 'on') {
                    if (!array_key_exists($tax->t_class, $finalTaxes)) {
                        $finalTaxes[$tax->t_class] = [];
                    }
                    if (!array_key_exists('amount', $finalTaxes[$tax->t_class])) {
                        $finalTaxes[$tax->t_class]['amount'] = 0;
                    }
                    if (!array_key_exists($tax->t_name, $finalTaxes[$tax->t_class])) {
                        $finalTaxes[$tax->t_class]['title'] = $tax->t_name;
                    }
                    if (!array_key_exists($tax->t_name, $finalTaxes[$tax->t_class])) {
                        $finalTaxes[$tax->t_class][$tax->t_name] = $tax->t_name;
                    }
                    $finalTaxes[$tax->t_class]['amount'] += $tax->t_rate * $taxeParams->amount / 100;
                }
            }
        }
        return $this->taxesHtmlAndtotal((object) $finalTaxes);
    }

    private function taxesHtmlAndtotal(object $finalTaxes) : array
    {
        $taxeTemplate = $this->paths->offsetGet('texesPath');
        $temp = '';
        $this->isFileexists($taxeTemplate);
        $taxeTemplate = file_get_contents($taxeTemplate);
        $totalTaxes = $this->money->getCustomAmt('0', 2);
        foreach ($finalTaxes as $class => $taxeParam) {
            $taxe = $this->money->getCustomAmt(strval($taxeParam['amount']), 2, $this->money->roundedDown());
            $html = str_replace('{{tax-class}}', $class ?? '', $taxeTemplate);
            $html = str_replace('{{title}}', $taxeParam['title'] ?? '', $html);
            $html = str_replace('{{tax_amount}}', $taxe->formatTo('fr_FR') ?? '', $html);
            $totalTaxes = $totalTaxes->plus($taxe->getAmount());
            $temp .= $html;
        }
        return [$temp, $totalTaxes->getAmount()];
    }

    private function getAllTaxes() : CollectionInterface
    {
        /** @var CacheInterface */
        $cache = Container::getInstance()->make(CacheInterface::class);
        if (!$cache->exists('userCartTaxes')) {
            $categories = array_unique(array_column($this->obj->all(), 'cat_id'));
            $cache->set('userCartTaxes', (new TaxesManager())->getTaxSystem($categories));
        }
        return $cache->get('userCartTaxes');
    }

    private function totalHT() : Money
    {
        if ($this->obj->count() > 0) {
            $price = $this->money->getCustomAmt('0', 2);
            foreach ($this->obj as $product) {
                $price = $price->plus($this->money->getCustomAmt($product->regular_price, 2));
            }
            return $price;
        }
    }
}