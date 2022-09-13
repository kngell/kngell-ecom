<?php

declare(strict_types=1);
class DetailsController extends Controller
{
    /**
     * IndexPage
     * ===================================================================.
     * @param array $data
     * @return void
     */
    protected function singlePage(array $data = []) : void
    {
        $slug = array_pop($data);
        $this->render('phones' . DS . 'details', $this->showParams($slug));
    }

    protected function singleClothesPage(array $data = []) : void
    {
        $slug = array_pop($data);
        $this->render('clothes' . DS . 'details', $this->showParams($slug, SingleClothesPage::class, 3, 'single_clophes'));
    }

    private function showParams(?string $slug, ?string $class = 'SinglePhonePage', int $brand = 2, ?string $cache = 'phones_products') : array
    {
        return $this->container($class, [
            'product' => $this->getSingleProduct($slug),
            'products' => $this->getProducts(brand: $brand, cache: $cache),
            'userCart' => $this->container(DisplayUserCart::class, [
                'userCart' => $this->getUserCart(),
            ]),
        ])->displayAll();
    }
}
