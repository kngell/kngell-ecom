<?php

declare(strict_types=1);

class ModalsPaths implements PathsInterface
{
    private string $viewPath = VIEW . 'client' . DS . 'components' . DS . 'modals' . DS;
    private string $templatePath = APP . 'Display' . DS . 'Components' . DS . 'Modals' . DS . 'Templates' . DS;

    public function Paths(): CollectionInterface
    {
        return new Collection(array_merge($this->templatesPath(), $this->viewPath()));
    }

    private function templatesPath() : array
    {
        return [
            'addAddressModalPath' => $this->templatePath . 'addAdressModal.php',

        ];
    }

    private function viewPath() : array
    {
        return [
            'addAddressPath' => $this->viewPath . '_checkout_add_address.php',
        ];
    }
}
