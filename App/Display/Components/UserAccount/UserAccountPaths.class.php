<?php

declare(strict_types=1);

class UserAccountPaths implements PathsInterface
{
    private string $viewPath = VIEW . 'client' . DS . 'components' . DS . 'user_account' . DS . 'partials' . DS;
    private string $templatePath = APP . 'Display' . DS . 'Components' . DS . 'UserAccount' . DS . 'Templates' . DS;

    public function Paths(): CollectionInterface
    {
        return new Collection(array_merge($this->templatesPath(), $this->viewPath()));
    }

    private function templatesPath() : array
    {
        return [
            'userProfilePath' => $this->templatePath . 'userProfileTemplate.php',
            'buttonsPath' => $this->templatePath . 'buttonsTemplate.php',
            'removeAccountPath' => $this->templatePath . 'removeAccountFrmTemplate.php',
            'userFormPath' => $this->templatePath . 'userFormTemplate.php',
            'showOrdersPath' => $this->templatePath . 'showOrdersTemplate.php',
            'itemInfosPath' => $this->templatePath . 'ordersItemsInfosTemplate.php',
        ];
    }

    private function viewPath() : array
    {
        return [
            'userCardPaymentPath' => $this->viewPath . '_user_payment_card.php',
            'menuPath' => $this->viewPath . '_transaction_menu.php',

        ];
    }
}