<?php

declare(strict_types=1);

class ShowUserCard extends AbstractShowUserCard implements DisplayPagesInterface
{
    public function __construct(?CustomerEntity $customerEntity, ?UserAccountPaths $paths = null)
    {
        parent::__construct($customerEntity, $paths);
    }

    public function displayAll(): mixed
    {
        $template = $this->getTemplate('userCardPath');
        $template = str_replace('{{userCard_item}}', $this->userCardItem(), $template);
        $template = str_replace('{{card_list}}', $this->cardList(), $template);

        return $template;
    }
}
