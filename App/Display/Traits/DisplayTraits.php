<?php

declare(strict_types=1);

trait DisplayTraits
{
    protected function invoke(array $args = []) : array
    {
        $resp = [];
        if (!empty($args)) {
            foreach ($args as $arg) {
                if ($arg instanceof Closure) {
                    $resp[] = $arg->__invoke();
                } else {
                    $resp[] = $arg;
                }
            }
        }
        return $resp;
    }

    protected function isFileexists(string $file) : bool
    {
        if (!file_exists($file)) {
            throw new BaseException('File does not exist!', 1);
        }
        return true;
    }

    protected function getTemplate(string $path) : string
    {
        $this->isFileexists($this->paths->offsetGet($path));
        return file_get_contents($this->paths->offsetGet($path));
    }

    protected function media(object $obj) : string
    {
        if (isset($obj->media) && !is_null($obj->media)) {
            $media = unserialize($obj->media);
            if (is_array($media) && count($media) > 0) {
                return str_starts_with($media[0], IMG) ? $media[0] : IMG . $media[0];
            }
        }
        return '';
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

    protected function filterTaxe(mixed $HT, object $product, CollectionInterface $taxes) : object
    {
        $productTaxes = $taxes->filter(fn ($taxe) => $product->cat_id == $taxe->tr_catID);
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
                $price = $price->plus($this->money->getCustomAmt(strval($product->regular_price * $product->item_qty), 2));
            }
            return $price;
        }
    }

    protected function customer(?Customer $customer = null) : ?Customer
    {
        $session = Container::getInstance()->make(SessionInterface::class);
        if (null !== $customer && $customer->getEntity()->isInitialized('address')) {
            if ($customer->getEntity()->{$customer->getEntity()->getGetters('address')}()->count() > 0) {
                return $customer;
            }
        }
        if ($session->exists(CHECKOUT_PROCESS_NAME)) {
            $customerEntity = unserialize($session->get(CHECKOUT_PROCESS_NAME));
            $customer = $customer->setEntity($customerEntity);
            return $customer;
        }
        if (null !== $customer) {
            return $customer;
        }
        throw new BaseException('Customer does not exist!');
    }
}