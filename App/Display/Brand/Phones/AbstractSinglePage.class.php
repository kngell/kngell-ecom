<?php

declare(strict_types=1);

abstract class AbstractSinglePage
{
    use DisplayTraits;
    use PhonesHomePageTraits;
    protected ?object $product;
    protected CollectionInterface|Closure $products;
    protected ?object $userCart;
    protected FormBuilder $frm;
    protected MoneyManager $money;
    protected CookieInterface $cookie;
    protected CollectionInterface $paths;

    public function __construct(?object $product, CollectionInterface|Closure $products, ?object $userCart, FormBuilder $frm, MoneyManager $money, CookieInterface $cookie, ?PhonesHomePagePaths $paths)
    {
        $this->product = $product;
        $this->products = $products;
        $this->userCart = $userCart;
        $this->frm = $frm;
        $this->money = $money;
        $this->cookie = $cookie;
        $this->paths = $paths->Paths();
    }

    protected function outputSingleProduct(string $template, $p) : string
    {
        $p->userCart = $this->userCart->getUserCart();
        $template = str_replace('{{title}}', $p->title ?? 'Unknown', $template);
        $template = str_replace('{{brand}}', $p->item_brand ?? 'Brand', $template);
        $template = str_replace('{{image}}', $this->media($p), $template);
        $media = is_string($p->media) ? unserialize($p->media) : $p->media;
        if (isset($media) && is_array($media) && count($media) > 0) {
            $galleryTemplate = $this->getTemplate('imgGalleryTemplate');
            $htmlGallery = '';
            foreach ($media as $img) {
                $htmlItem = str_replace('{{imageGallery}}', ImageManager::asset_img($img), $galleryTemplate);
                $htmlItem = str_replace('{{title}}', $p->title, $htmlItem);
                $htmlGallery .= $htmlItem;
            }
            $template = str_replace('{{imageGalleryTemplate}}', $htmlGallery, $template);
        }
        $template = str_replace('{{proceedToBuyForm}}', $this->productForm($p, 'Proceed to buy'), $template);
        $template = str_replace('{{addToCartForm}}', $this->productForm($p, 'Add to Cart'), $template);
        $template = str_replace('{{comparePrice}}', $this->money->getFormatedAmount($p->compare_price), $template);
        $template = str_replace('{{regularPrice}}', $this->money->getFormatedAmount($p->regular_price), $template);
        $template = str_replace('{{savings}}', $this->money->getFormatedAmount(strval($p->compare_price - $p->regular_price)), $template);
        $template = str_replace('{{imageUser}}', ImageManager::asset_img('users/avatar.png'), $template);
        $template = str_replace('{{imageUser2}}', ImageManager::asset_img('users/default-female-avatar.jpg'), $template);

        return $template;
    }
}
