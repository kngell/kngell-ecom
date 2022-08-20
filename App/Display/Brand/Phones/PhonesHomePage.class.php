<?php

declare(strict_types=1);

class PhonesHomePage extends AbstractBrandPage implements DisplayPagesInterface
{
    use PhonesHomePageTraits;

    public function __construct(CollectionInterface|closure $products, ?FormBuilder $frm = null, ?object $userCart = null, CollectionInterface|Closure $slider = null, ?PhonesHomePagePaths $paths = null, ?MoneyManager $money = null)
    {
        parent::__construct([
            'products' => $products,
            'frm' => $frm,
            'userCart' => $userCart,
            'slider' => $slider,
            'paths' => $paths->Paths(),
            'money' => $money,
        ]);
        $this->slider = $this->slider != null ? $this->slider->filter(function ($sld) {
            return $sld->page_slider === 'index_phone';
        }) : null;
    }

    public function displayAll(): array
    {
        return array_merge([
            'topSales' => $this->displayTopSalesSetion(),
            'specialPrice' => $this->displaySpecialPriceSection(),
            'bannerAdds' => $this->displayBannerAddsSection(),
            'newProducts' => $this->displayNewProductsSection(),
            'bannerArea' => $this->displayBannerAreaSection(),
            'blogArea' => $this->displayBlogArea(),
        ], $this->userCart->displayAll());
    }

    public function displayTopSalesSetion() : string
    {
        $topSalesTemplate = $this->getTemplate('topSalesPath');
        $productTemplate = $this->getTemplate('topSalesTemplatePath');
        $productTemplate = str_replace('{{singleProductTemplate}}', $this->getTemplate('productTemplatePath'), $productTemplate);
        return $this->iteratedOutput($topSalesTemplate, $productTemplate);
    }

    private function displayBlogArea() : string
    {
        $blogTemplate = $this->getTemplate('blogAreaPath');
        $blogTemplate = str_replace('{{blog1}}', ImageManager::asset_img('blog' . DS . 'blog1.jpg'), $blogTemplate);
        $blogTemplate = str_replace('{{blog2}}', ImageManager::asset_img('blog' . DS . 'blog2.jpg'), $blogTemplate);
        $blogTemplate = str_replace('{{blog3}}', ImageManager::asset_img('blog' . DS . 'blog3.jpg'), $blogTemplate);
        return $blogTemplate;
    }

    private function displayBannerAreaSection() : string
    {
        $bannerAreaTemplate = $this->getTemplate('bannerAreaPath');
        $imgTemplate = $this->getTemplate('bannerTemplatePath');
        $html = '';
        if ($this->slider->count() === 1) {
            $slider = $this->slider->pop();
            $medias = unserialize($slider->media);
            foreach ($medias as $image) {
                $imgTemplate = str_replace('{{image}}', ImageManager::asset_img($image), $imgTemplate);
                $imgTemplate = str_replace('{{title}}', $slider->slider_title, $imgTemplate);
                $html .= $imgTemplate;
            }
        }
        return str_replace('{{bannerTemplate}}', $html, $bannerAreaTemplate);
    }

    private function displayNewProductsSection() : string
    {
        $newProductsTemplate = $this->getTemplate('newProductPath');
        $productTemplate = $this->getTemplate('newProductTemplate');
        $productTemplate = str_replace('{{singleProductTemplate}}', $this->getTemplate('productTemplatePath'), $productTemplate);
        return $this->iteratedOutput($newProductsTemplate, $productTemplate);
    }

    private function displayBannerAddsSection() : string
    {
        $bannerAddTemplate = $this->getTemplate('bannerAddPath');
        $bannerAddTemplate = str_replace('{{banner1}}', ImageManager::asset_img('banner1-cr-500x150.jpg'), $bannerAddTemplate);
        $bannerAddTemplate = str_replace('{{banner2}}', ImageManager::asset_img('banner2-cr-500x150.jpg'), $bannerAddTemplate);

        return $bannerAddTemplate;
    }

    private function displaySpecialPriceSection() : string
    {
        $brandButton = $this->categoriesButton();
        $specialTemplate = $this->getTemplate('specialPricePath');
        $productTemplate = $this->getTemplate('specialPriceTemplate');
        $specialTemplate = str_replace('{{brandButton}}', !empty($brandButton) ? implode('', $brandButton) : '', $specialTemplate);
        $productTemplate = str_replace('{{singleProductTemplate}}', $this->getTemplate('productTemplatePath'), $productTemplate);

        return $this->iteratedOutput($specialTemplate, $productTemplate);
    }

    private function categoriesButton() :  array
    {
        $brandButton = [];
        if ($this->products->count() > 0) {
            $brands = array_unique(array_map(function ($prod) {
                return $prod->categorie;
            }, $this->products->all()));
            sort($brands);
            if (isset($brands)) {
                $brandButton = array_map(function ($brand) {
                    return sprintf('<button class="btn" data-filter=".%s">%s</button>', $brand, $brand);
                }, $brands);
            }
        }
        return $brandButton;
    }

    private function iteratedOutput(string $template, string $productTemplate) : string
    {
        $html = '';
        if ($this->products->count() > 0) {
            $this->products->shuffle();
            foreach ($this->products as $product) {
                $html .= $this->outputProduct($productTemplate, $product);
            }
        }
        return str_replace('{{productsTemplate}}', $html, $template);
    }
}