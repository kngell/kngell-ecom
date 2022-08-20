<?php

declare(strict_types=1);

class ClothesShopPage extends AbstractBrandPage implements DisplayPagesInterface
{
    use ClothesPageTrait;
    private string $shopItem;

    public function __construct(CollectionInterface|closure $products, ?FormBuilder $frm, ?object $userCart, ?ClothesHomePagePaths $paths = null, ?MoneyManager $money = null)
    {
        parent::__construct([
            'products' => $products,
            'frm' => $frm,
            'userCart' => $userCart,
            'paths' => $paths->Paths(),
            'money' => $money,
        ]);
        $this->shopItem = $this->getTemplate('shopItemTemplate');
    }

    public function displayAll(): mixed
    {
        return [
            'shop_products' => $this->shopPage($this->getTemplate('shopTemplate')),
        ];
    }

    protected function shopPage(?string $template = null) : string
    {
        $html = '';
        $table = $this->simulDatabaseIncome()['shop'];
        foreach ($table as $obj) {
            $temp = str_replace('{{image}}', ImageManager::asset_img($obj->img), $this->shopItem);
            $temp = str_replace('{{title}}', $obj->title, $temp);
            $temp = str_replace('{{price}}', $obj->price, $temp);
            $temp = str_replace('{{button}}', $this->clothesButton(), $temp);
            $html .= $temp;
        }
        return str_replace('{{shop_items_collection}}', $html, $template);
    }
}