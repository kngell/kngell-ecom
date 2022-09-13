<?php

declare(strict_types=1);

class SinglePhonePage extends AbstractSinglePage implements DisplayPagesInterface
{
    protected CollectionInterface $paths;

    public function __construct(?object $product, CollectionInterface|Closure $products, ?object $userCart, FormBuilder $frm, MoneyManager $money, CookieInterface $cookie, ?PhonesHomePagePaths $paths)
    {
        parent::__construct($product, $products, $userCart, $frm, $money, $cookie, $paths);
    }

    public function displayAll(): mixed
    {
        return [
            'singleProduct' => $this->singleProduct(),
            'topSales' => Container::getInstance()->make(PhonesHomePage::class, [
                'products' => $this->products,
                'frm' => $this->frm,
                'userCart' => $this->userCart,
            ])->displayTopSalesSetion(),
        ];
    }

    protected function singleProduct() : string
    {
        if (count((array) $this->product) !== 0) {
            $template = $this->getTemplate('productDetailsPath');

            return $this->outputSingleProduct($template, $this->product);
        } else {
            return '<div class="text-center text-lead py-5">
            <h5>This product was not found</h5>
            </div>';
        }
    }
}
