<?php

declare(strict_types=1);

class CreditCardPaths implements PathsInterface
{
    private string $templatePath = APP . 'Display' . DS . 'Components' . DS . 'CreditCard' . DS . 'Templates' . DS;
    private string $viewPath = VIEW . 'client' . DS . 'components' . DS . 'credit_card' . DS;

    public function Paths(): CollectionInterface
    {
        return new Collection(array_merge($this->templates(), $this->views()));
    }

    private function templates() : array
    {
        return [
            'creditCardPath' => $this->templatePath . 'creditCardTemplate.php',
            'creditCardFormPath' => $this->templatePath . 'creditCardFormTemplate.php',
        ];
    }

    private function views() : array
    {
        return [
            'ccFrontPath' => $this->viewPath . '_cc_front.php',
            'ccBackPath' => $this->viewPath . '_cc_back.php',
        ];
    }
}