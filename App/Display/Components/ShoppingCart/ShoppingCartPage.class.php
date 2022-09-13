<?php

declare(strict_types=1);

class ShoppingCartPage extends AbstractShoppingCartPage implements DisplayPagesInterface
{
    private string $shoppinCartItems;
    private string $shoppinCartTotal;
    private string $whishlistItems;

    public function __construct(?CollectionInterface $cartItems = null, ?ShoppingCartPaths $paths = null, ?MoneyManager $money = null, ?FormBuilder $frm = null)
    {
        parent::__construct($cartItems, $paths, $money, $frm);
        $this->shoppinCartItems = $this->shoppingCartItems();
        $this->shoppinCartTotal = $this->shoppingCartSubtotal();
        $this->whishlistItems = $this->whishlistItems();
    }

    public function displayAll(): array
    {
        $shopping_cart_template = $this->getTemplate('shoppingCartPath');
        $whishlist_template = $this->getTemplate('whishlistPath');
        $c = [
            'shoppingCart' => $this->outputShoppingCart($shopping_cart_template),
            'whislist' => $this->outputWhishlist($whishlist_template),
        ];

        return $c;
    }

    public function items() : string
    {
        return $this->shoppinCartItems;
    }

    public function total() : string
    {
        return $this->shoppinCartTotal;
    }

    protected function outputWhishlist(?string $template = null) : string
    {
        $temp = '';
        if (!is_null($template)) {
            $temp = str_replace('{{whishlist_items}}', $this->whishlistItems, $template);
            $temp = str_replace('{{display}}', $this->wishlistStyle, $temp);
        }

        return $temp;
    }

    protected function outputShoppingCart(?string $template = null) : string
    {
        $temp = '';
        if (!is_null($template)) {
            $temp = str_replace('{{shopping_cart_items}}', $this->shoppinCartItems, $template);
            $temp = str_replace('{{shopping_cart_subTotal}}', $this->shoppinCartTotal, $temp);
        }

        return $temp;
    }
}
