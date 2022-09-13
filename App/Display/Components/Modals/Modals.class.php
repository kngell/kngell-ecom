<?php

declare(strict_types=1);

class Modals extends AbstractModals implements DisplayPagesInterface
{
    public function __construct(?FormBuilder $frm = null, ?ModalsPaths $paths = null)
    {
        parent::__construct($frm, $paths);
    }

    public function displayAll(): mixed
    {
        return '';
    }

    public function addAddressModal() : string
    {
        $template = $this->getTemplate('addAddressModalPath');
        $this->frm->form([
            'action' => '',
            'id' => 'add-address-frm',
            'class' => ['add-address-frm'],
        ]);
        $template = str_replace('{{form_begin}}', $this->frm->begin(), $template);
        $template = str_replace('{{addAddressContent}}', $this->AddAdressContent(), $template);
        $template = str_replace('{{form_end}}', $this->frm->end(), $template);

        return $template;
    }
}
