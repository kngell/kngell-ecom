<?php

declare(strict_types=1);

trait ClothesPageTrait
{
    protected function backgroudImage() : string
    {
        if ($this->slider->count() > 0) {
            $url = '';
            foreach ($this->slider as $media) {
                $images = unserialize($media->media);
                if (is_array($images) && !empty($images)) {
                    foreach ($images as $image) {
                        $end = next($images) === true ? ',' : ';';
                        $url .= 'url(' . ImageManager::asset_img(str_replace('\\', '/', $image)) . ')' . $end;
                    }
                }
            }

            return 'style="background-image: ' . $url . ' "';
        }

        return '';
    }

    protected function simulDatabaseIncome() : array
    {
        return [
            'arrivals' => [
                (object) ['img' => 'arrivals/1.jpg', 'title' => 'Extreme Rare Sneakers'],
                (object) ['img' => 'arrivals/5.jpg', 'title' => 'Awesome Black Outfit'],
                (object) ['img' => 'arrivals/3.jpg', 'title' => 'SportWare Up to 50% Off'],
            ],
            'dresseSuits' => [
                (object) ['img' => 'clothes/1.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'clothes/2.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'clothes/3.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'clothes/4.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
            ],
            'bestWishes' => [
                (object) ['img' => 'watches/1.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'watches/1.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'watches/3.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'watches/4.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
            ],
            'shop' => [
                (object) ['img' => 'shop/23.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/20.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/15.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/10.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/9.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/8.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/7.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/25.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/23.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/17.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/26.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/20.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/18.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/16.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/14.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/13.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/12.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/11.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/19.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/20.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/12.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/8.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'shop/25.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
            ],
            'relatedProducts' => [
                (object) ['img' => 'featured/1.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'featured/2.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'featured/3.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
                (object) ['img' => 'featured/4.jpg', 'title' => 'Sports Shoes', 'price' => '$59.00'],
            ],

        ];
    }

    protected function clothesButton() : string
    {
        return $this->frm->input([
            ButtonType::class => ['type' => 'button', 'class' => ['buy-btn']],
        ])->content('Buy Now')->html();
    }
}
