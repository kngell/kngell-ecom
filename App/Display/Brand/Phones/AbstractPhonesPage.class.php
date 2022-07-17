<?php

declare(strict_types=1);

abstract class AbstractPhonesPage
{
    use DisplayTraits;
    protected array|closure $products;
    protected ?ProductsManager $pm;
    protected ?stdClass $product;
    protected ?FormComponent $frm;
    protected ?object $userCart;
    protected ?CollectionInterface $paths;
    protected ?MoneyManager $money = null;

    public function __construct(array|closure $products, ?FormComponent $frm, ?ProductsManager $pm, ?object $userCart = null, ?PhonesHomePagePaths $paths = null, ?MoneyManager $money = null)
    {
        list($this->products) = $this->invoke([$products]);
        $this->pm = $pm;
        $this->frm = $frm;
        $this->userCart = $userCart;
        $this->paths = $paths->Paths();
        $this->money = $money;
    }

    protected function outputProduct(string $template, ?stdClass $product = null) : string
    {
        $product->userCart = $this->userCart->getUserCart();
        $template = str_replace('{{route}}', 'product' . DS . $product->slug, $template);
        $template = str_replace('{{image}}', $product->media != '' ? ImageManager::asset_img(unserialize($product->media)[0]) : ImageManager::asset_img('products/1.png'), $template);
        $template = str_replace('{{title}}', $product->title ?? 'Unknown', $template);
        $template = str_replace('{{price}}', (string) $this->money->getFormatedAmount(strval($product->regular_price)), $template);
        $template = str_replace('{{ProductForm}}', $this->productForm($product), $template);
        $template = str_replace('{{brandClass}}', $product->categorie ?? 'Brand', $template);
        return $template;
    }

    protected function productForm(object $product) : string
    {
        $form = $this->frm->form([
            'action' => '',
            'class' => ['add_to_cart_frm'],
        ]);

        list($class, $title) = $this->producttitleAndClass($product);
        $template = $this->getTemplate('productFormPath');
        $form->setCsrfKey('add_to_cart_frm' . $product->pdt_id ?? 1);
        $template = str_replace('{{form_begin}}', $form->begin(), $template);
        $template = str_replace('{{item}}', (string) $form->input([
            HiddenType::class => ['name' => 'item_id'],
        ])->noLabel()->value($product->pdt_id), $template);
        $template = str_replace('{{user}}', (string) $form->input([
            HiddenType::class => ['name' => 'user_id'],
        ])->noLabel()->value('1'), $template);
        $template = str_replace('{{button}}', (string) $form->input([
            ButtonType::class => ['type' => 'submit', 'class' => $class],
        ])->content($title), $template);
        $template = str_replace('{{form_end}}', $form->end(), $template);
        return $template;
    }

    protected function outputSingleProduct(string $template) : string
    {
        $p = $this->product;
        $template = str_replace('{{title}}', $p->title ?? 'Unknown', $template);
        $template = str_replace('{{brand}}', $p->item_brand ?? 'Brand', $template);
        $template = str_replace('{{image}}', isset($p->media) ? $p->media[0] : ImageManager::asset_img('products/product-540x60.jpg'), $template);
        if (isset($p->media) && count($p->media) > 0) {
            $galleryTemplate = $this->getTemplate(APP . 'Display' . DS . 'Products' . DS . 'Phones' . DS . 'Templates' . DS . 'imageGalleryTemplate.php');
            $htmlGallery = '';
            for ($i = 0; $i < count($p->media); $i++) {
                $htmlItem = str_replace('{{imageGallery}}', isset($p->media[$i]) ? $p->media[$i] : ImageManager::asset_img('products/product-540x60.jpg'), $galleryTemplate);
                $htmlItem = str_replace('{{title}}', $p->title, $htmlItem);
                $htmlGallery .= $htmlItem;
            }
            $template = str_replace('{{imageGalleryTemplate}}', $htmlGallery, $template);
            $template = str_replace('{{proceedToBuyForm}}', $this->proceedToBuy->createForm(''), $template);
            $template = str_replace('{{addToCartForm}}', $this->addToCart->createForm('', $p), $template);
            $template = str_replace('{{comparePrice}}', (string) $this->pm->getMoney()->getAmount($p->compare_price), $template);
            $template = str_replace('{{regularPrice}}', (string) $this->pm->getMoney()->getAmount($p->regular_price), $template);
            $template = str_replace('{{savings}}', (string) $this->money->getFormatedAmount(strval($p->compare_price - $p->regular_price)), $template);
            $template = str_replace('{{imageUser}}', ImageManager::asset_img('users/avatar.png'), $template);
            $template = str_replace('{{imageUser2}}', ImageManager::asset_img('users/default-female-avatar.jpg'), $template);
        }
        return $template;
    }

    private function producttitleAndClass(?object $dataRepository = null) : array
    {
        /** @var CollectionInterface */
        $userCart = $dataRepository->userCart;
        $cartKeys = $userCart->map(function ($item) {
            if ($item->cart_type == 'cart') {
                return $item->item_id;
            }
        })->all();
        if (isset($cartKeys) && in_array($dataRepository->pdt_id, $cartKeys)) {
            return [['btn', 'btn-success', 'font-size-12'], 'In the Cart'];
        }
        return [['btn', 'btn-warning', 'font-size-12'], 'Add to Cart'];
    }
}