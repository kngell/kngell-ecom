<?php

declare(strict_types=1);

class AddressBookPath implements PathsInterface
{
    private string $templatePath = APP . 'Display' . DS . 'Components' . DS . 'AddressBook' . DS . 'Templates' . DS;

    public function Paths() : CollectionInterface
    {
        return new Collection(array_merge($this->templates(), $this->AddressBookfiles()));
    }

    private function templates() : array
    {
        return [
            'addressBookPath' => $this->templatePath . 'addressBookTemplate.php',
            'addressBookContentPath' => $this->templatePath . 'addressBookContentTemplate.php',
        ];
    }

    private function AddressBookfiles() : array
    {
        return [];
    }
}
