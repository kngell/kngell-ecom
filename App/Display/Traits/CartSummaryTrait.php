<?php

declare(strict_types=1);

trait CartSummaryTrait
{
    protected function filterTaxe(mixed $HT, object $product, CollectionInterface $taxes, int $item_qty) : object
    {
        $productTaxes = $taxes->filter(fn ($taxe) => $product->cat_id == $taxe->tr_catID);
        if (property_exists($this, 'userItems')) {
            $this->userItems[] = ['id' => $product->item_id, 'HT' => $HT, 'taxes' => $productTaxes, 'item_qty' => $item_qty];
        }
        return (object) ['item' => $product->item_id, 'taxes' => $productTaxes, 'amount' => $HT];
    }

    protected function getAllTaxes(CollectionInterface $userCart) : CollectionInterface
    {
        /** @var CacheInterface */
        $cache = Container::getInstance()->make(CacheInterface::class);
        if (!$cache->exists('userCartTaxes')) {
            $categories = array_unique(array_column($userCart->all(), 'cat_id'));
            $cache->set('userCartTaxes', (new TaxesManager())->getTaxSystem($categories));
        }
        return $cache->get('userCartTaxes');
    }

    protected function taxesHtmlAndtotal(object $finalTaxes, string $taxeTemplate) : array
    {
        $temp = '';
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

    protected function totalHT(CollectionInterface $obj) : Brick\Money\Money
    {
        if ($obj->count() > 0) {
            $price = $this->money->getCustomAmt('0', 2);
            foreach ($obj as $product) {
                if ($product->cart_type == 'cart') {
                    $price = $price->plus($this->money->getCustomAmt(strval($product->regular_price * $product->item_qty), 2));
                }
            }
            return $price;
        }
        return $this->money->getCustomAmt(strval(0), 2);
    }

    protected function calcTaxes(?array $taxesProducts) : CollectionInterface
    {
        $finalTaxes = [];
        foreach ($taxesProducts as $taxeParams) {
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
        return new Collection($finalTaxes);
    }
}