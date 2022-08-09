<?php

declare(strict_types=1);

class ShoppingCartPaths implements PathsInterface
{
    private string $partialsPath = VIEW . 'client' . DS . 'components' . DS . 'shoppingCart' . DS . 'partials' . DS;
    private string $templatePath = APP . 'Display' . DS . 'Components' . DS . 'ShoppingCart' . DS . 'Templates' . DS;

    public function Paths(): CollectionInterface
    {
        return new Collection(array_merge($this->templatesPath(), $this->partialsPath()));
    }

    private function templatesPath() : array
    {
        return [
            'shoppingItemPath' => $this->templatePath . 'shoppingItemTemplate.php',
            'shoppingItemCollectionPath' => $this->templatePath . 'shoppingItemCollectionTemplate.php',
            'shoppingQtyformPath' => $this->templatePath . 'shoppingItemQtyFormTemplate.php',
            'shoppingDelFormPath' => $this->templatePath . 'shoppingItemDelFormTemplate.php',
            'cartTaxTemplate' => $this->templatePath . 'shoppingCartTaxesTemplate.php',
            'proceedTobuyFormPath' => $this->templatePath . 'proceedToBuyFormTemplate.php',

        ];
    }

    private function partialsPath() : array
    {
        return [
            'shoppingCartPath' => $this->partialsPath . '_shopping_cart.php',
            'emptycartPath' => $this->partialsPath . '_empty_shopping_cart.php',
            'shoppingCartsubtotalPath' => $this->partialsPath . '_shopping_cart_subTotal.php',
        ];
    }
}