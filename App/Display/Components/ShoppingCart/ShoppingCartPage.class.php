<?php

declare(strict_types=1);

class ShoppingCartPage extends AbstractShoppingCartPage implements DisplayPagesInterface
{
    public function __construct(?CollectionInterface $cartItems = null, ?ShoppingCartPaths $paths = null, ?MoneyManager $money = null, ?FormBuilder $frm = null)
    {
        parent::__construct($cartItems, $paths, $money, $frm);
    }

    public function displayAll(): array
    {
        $template = $this->getTemplate('shoppingCartPath');
        return [
            'shoppingCart' => $this->outputShoppingCart($template),
        ];
    }

    protected function outputShoppingCart(?string $template = null) : string
    {
        $temp = '';
        if (!is_null($template)) {
            $temp = str_replace('{{shopping_cart_items}}', $this->shoppingCartItems(), $template);
            $temp = str_replace('{{shopping_cart_subTotal}}', $this->shoppingCartSubtotal(), $temp);
        }
        return $temp;
    }
}
