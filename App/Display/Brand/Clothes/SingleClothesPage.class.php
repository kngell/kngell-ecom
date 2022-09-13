<?php

declare(strict_types=1);

class SingleClothesPage extends AbstractBrandPage implements DisplayPagesInterface
{
    use ClothesPageTrait;
    private string $relatedProduct;

    public function __construct(?object $product, CollectionInterface|Closure $products, ?object $userCart, FormBuilder $frm, MoneyManager $money, CookieInterface $cookie, ?ClothesHomePagePaths $paths)
    {
        parent::__construct([
            'product' => $product,
            'products' => $products,
            'userCart' => $userCart,
            'frm' => $frm,
            'money' => $money,
            'cookie' => $cookie,
            'paths' => $paths->paths(),
        ]);
        $this->relatedProduct = $this->getTemplate('relatedProductItemPath');
    }

    public function displayAll(): mixed
    {
        return [
            'details' => $this->detailsContent(),
            'related_products' => $this->relatedProducts($this->getTemplate('relatedProductPath')),
        ];
    }

    protected function detailsContent() : string
    {
        $p = $this->product;
        $template = $this->getTemplate('detailsPath');
        if (isset($this->product) && count((array) $this->product) > 0) {
            $template = str_replace('{{image}}', $this->media($p), $template);
            if (isset($p->media)) {
                $media = unserialize($p->media);
                $galleryTemplate = $this->getTemplate('imgGalleryTemplate');
                $htmlGallery = '';
                foreach ($media as $img) {
                    $htmlItem = str_replace('{{imageGallery}}', ImageManager::asset_img($img), $galleryTemplate);
                    $htmlItem = str_replace('{{title}}', $p->title, $htmlItem);
                    $htmlGallery .= $htmlItem;
                }
                $template = str_replace('{{imageGalleryTemplate}}', $htmlGallery, $template);
                $template = str_replace('{{brand}}', $p->br_name, $template);
                $template = str_replace('{{title}}', $p->title, $template);
                $template = str_replace('{{price}}', $this->money->getFormatedAmount(strval($p->compare_price ?? 0)), $template);
            }
        }

        return $template;
    }

    protected function relatedProducts(?string $template = null) : string
    {
        $html = '';
        $table = $this->simulDatabaseIncome()['relatedProducts'];
        foreach ($table as $obj) {
            $temp = str_replace('{{image}}', ImageManager::asset_img($obj->img), $this->relatedProduct);
            $temp = str_replace('{{title}}', $obj->title, $temp);
            $temp = str_replace('{{price}}', $obj->price, $temp);
            $temp = str_replace('{{button}}', $this->clothesButton(), $temp);
            $html .= $temp;
        }

        return str_replace('{{related_product_item}}', $html, $template);
    }
}
