<?php

declare(strict_types=1);

class ClothesHomePage extends AbstractBrandPage implements DisplayPagesInterface
{
    use ClothesPageTrait;

    private string $arrivalItem;
    private string $featureItem;
    private string $dressseSuit;
    private string $bestWishes;

    public function __construct(CollectionInterface|closure $products, ?FormBuilder $frm, ?object $userCart, CollectionInterface|Closure $slider, ?ClothesHomePagePaths $paths = null, ?MoneyManager $money = null)
    {
        parent::__construct([
            'products' => $products,
            'frm' => $frm,
            'userCart' => $userCart,
            'slider' => $slider,
            'paths' => $paths->Paths(),
            'money' => $money,
        ]);
        $this->slider = $this->slider->filter(function ($sld) {
            return $sld->page_slider === 'index_clothing';
        });
        $this->arrivalItem = $this->getTemplate('arrivalItemPath');
        $this->featureItem = $this->getTemplate('featuresItemsPath');
        $this->dressseSuit = $this->getTemplate('dresseSuitItemPath');
        $this->bestWishes = $this->getTemplate(('bestWishesItemPath'));
    }

    public function displayAll(): array
    {
        return [
            'main_clothes_section' => $this->mainClothesSection($this->getTemplate('mainClothesPath')),
            'brand_section' => $this->brandSection(),
            'arrival_section' => $this->arrivalsSection($this->getTemplate('arrivalsPath')),
            'features_section' => $this->featuresSection($this->getTemplate('featurePath')),
            'middle_season' => $this->middleSection(),
            'dresses_suits_section' => $this->dresseSuitsSection($this->getTemplate('dressesSuitPath')),
            'best_wishes_section' => $this->bestWishesSection($this->getTemplate('bestwishesPath'), $this->bestWishes, 'bestWishes'),

        ];
    }

    private function mainClothesSection(?string $template = null) : string
    {
        $slider = $this->slider();
        $temp = str_replace('{{imageStyle}}', $this->backgroudImage(), $template);
        $temp = str_replace('{{title}}', strtoupper($slider->slider_title), $temp);
        $title_split = array_map('trim', explode('|', $slider->slider_title));
        $temp = str_replace('{{title_left}}', ucfirst($title_split[0]), $temp);
        $temp = str_replace('{{title_right}}', ucfirst($title_split[1]), $temp);
        $text = array_map('trim', explode('|', $slider->slider_text));
        $temp = str_replace('{{text_left}}', $text[0], $temp);
        $temp = str_replace('{{text_right}}', $text[1], $temp);
        $temp = str_replace('{{btn_text}}', $slider->slider_btn_text, $temp);

        return $temp;
    }

    private function brandSection() : string
    {
        return $this->getTemplate('brandPath');
    }

    private function arrivalsSection(?string $template = null) : string
    {
        $btn = ucfirst('Shop Now');
        $html = '';
        $table = $this->simulDatabaseIncome()['arrivals'];
        foreach ($table as $obj) {
            $temp = str_replace('{{image}}', ImageManager::asset_img($obj->img), $this->arrivalItem);
            $temp = str_replace('{{title}}', $obj->title, $temp);
            $temp = str_replace('{{btn}}', $btn, $temp);
            $html .= $temp;
        }

        return str_replace('{{arrivals_items}}', $html, $template);
    }

    private function featuresSection(?string $template = null) : string
    {
        if ($this->products->count() > 0) {
            $this->products->shuffle();
            $html = '';
            foreach ($this->products as $product) {
                if ($product->categorie == 'Chaussures') {
                    $temp = str_replace('{{route}}', 'details' . DS . 'single_clothes' . DS . $product->slug, $this->featureItem);
                    $temp = str_replace('{{image}}', $this->media($product), $temp);
                    $temp = str_replace('{{title}}', $product->title ?? 'Unknown', $temp);
                    $temp = str_replace('{{price}}', $this->money->getFormatedAmount(strval($product->regular_price == null ? 0 : $product->regular_price)), $temp);
                    $temp = str_replace('{{button}}', $this->clothesButton(), $temp);
                    $html .= $temp;
                }
            }

            return str_replace('{{features_items}}', $html, $template);
        }

        return '';
    }

    private function middleSection() : string
    {
        return $this->getTemplate('middleSeasonPath');
    }

    private function dresseSuitsSection(?string $template = null) : string
    {
        $html = '';
        $table = $this->simulDatabaseIncome()['dresseSuits'];
        foreach ($table as $obj) {
            $temp = str_replace('{{image}}', ImageManager::asset_img($obj->img), $this->dressseSuit);
            $temp = str_replace('{{title}}', $obj->title, $temp);
            $temp = str_replace('{{price}}', $obj->price, $temp);
            $temp = str_replace('{{button}}', $this->clothesButton(), $temp);
            $html .= $temp;
        }

        return str_replace('{{dresses_suit_items}}', $html, $template);
    }

    private function bestWishesSection(?string $template = null) : string
    {
        $html = '';
        $table = $this->simulDatabaseIncome()['bestWishes'];
        foreach ($table as $obj) {
            $temp = str_replace('{{image}}', ImageManager::asset_img($obj->img), $this->bestWishes);
            $temp = str_replace('{{title}}', $obj->title, $temp);
            $temp = str_replace('{{price}}', $obj->price, $temp);
            $temp = str_replace('{{button}}', $this->clothesButton(), $temp);
            $html .= $temp;
        }

        return str_replace('{{best_wishes_items}}', $html, $template);
    }
}
