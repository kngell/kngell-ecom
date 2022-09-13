<?php

declare(strict_types=1);

class AbstractShowUserCard
{
    use DisplayTraits;
    use UserAccountGettersAndSettersTrait;

    protected ?CollectionInterface $paths;
    protected ?CustomerEntity $customerEntity;
    protected string $cardItem;

    public function __construct(?CustomerEntity $customerEntity, ?UserAccountPaths $paths = null)
    {
        $this->paths = $paths->Paths();
        $this->customerEntity = $customerEntity;
        $this->cardItem = $this->getTemplate('userCardItemPath');
    }

    protected function userCardItem() : string
    {
        $cardItemHtml = '';
        if ($this->customerEntity->isInitialized('user_cards')) {
            $cardList = $this->customerEntity->getUserCards()->data;
            if (count($cardList) > 0) {
                foreach ($cardList as $card) {
                    $temp = str_replace('{{card_icon}}', $this->cardIcon($card), $this->cardItem);
                    $temp = str_replace('{{brand}}', $card->brand, $temp);
                    $temp = str_replace('{{last4}}', $card->last4, $temp);
                    $temp = str_replace('{{expiry}}', $card->exp_month . '/' . $card->exp_year, $temp);
                    $temp = str_replace('{{card_holder}}', $card->name ?? '', $temp);
                    $cardItemHtml .= $temp;
                }
            }
        }
        return $cardItemHtml;
    }

    protected function cardList() : string
    {
        $cardListHtml = '';
        if ($this->customerEntity->isInitialized('user_cards')) {
            $cardList = $this->customerEntity->getUserCards()->data;
            $temp = $this->getTemplate('userCardListPath');
            foreach ($cardList as $card) {
                $temp = str_replace('{{last4}}', $card->last4, $temp);
                $temp = str_replace('{{image}}', $this->cardImage($card), $temp);
                $cardListHtml .= $temp;
            }
        }
        return $cardListHtml;
    }

    protected function cardImage(object $card) : string
    {
        return match ($card->brand) {
            'Visa' => ImageManager::asset_img('card' . DS . 'visa.png')
        };
    }
}