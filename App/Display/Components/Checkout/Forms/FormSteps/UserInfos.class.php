<?php

declare(strict_types=1);

class UserInfos extends AbstractFormSteps implements CheckoutFormStepInterface
{
    private string $title = 'User Informations';

    public function __construct(array $params = [])
    {
        parent::__construct($params);

        $this->frm->globalClasses([
            'wrapper' => [],
            'input' => ['input-box__input'],
            'label' => ['input-box__label'],
        ]);
    }

    public function display() : string
    {
        $mainTemplate = $this->getTemplate('mainUserTemplate');
        $userData = $this->getTemplate('userDataPath');
        return $this->outputTemplate($mainTemplate, $userData, $this->userCart);
    }

    protected function titleTemplate(string $title = '') : string
    {
        $contactTitle = $this->getTemplate('contactTitlePath');
        return str_replace('{{accountCheckt}}', !AuthManager::isUserLoggedIn() ? $this->accountCheck() : '', $contactTitle);
    }

    private function outputTemplate(string $template = '', string $dataTemplate = '', ?CollectionInterface $obj = null) : string
    {
        $temp = '';
        if (!is_null($obj) && $obj->count() > 0) {
            $temp = str_replace('{{userCartSummary}}', $this->summary->display($this), $template);
            $temp = str_replace('{{data}}', $dataTemplate, $temp);
            $temp = str_replace('{{title}}', $this->titleTemplate($this->title), $temp);
            $temp = str_replace('{{contactContent}}', $this->contactInfosformElements($obj), $temp);
            $temp = str_replace('{{discountCode}}', $this->discountCode(), $temp);
            $temp = str_replace('{{display_style}}', !AuthManager::isUserLoggedIn() ? 'hide' : 'show', $temp);
            $temp = str_replace('{{deliveryAddressTitle}}', $this->deliveryAddressTitle(), $temp);
            $temp = str_replace('{{deliveryAddress}}', $this->deliveryAdress(), $temp);
            $temp = str_replace('{{buttons_group}}', $this->buttons(), $temp);
        }
        return $temp;
    }

    private function deliveryAdress() : string
    {
        if (AuthManager::isUserLoggedIn()) {
            list($htmlChk, $htmlModal, $text) = $this->addressBook->all('manage_frm');
            return $htmlChk;
        }
        return '';
    }

    private function deliveryAddressTitle() : string
    {
        return AuthManager::isUserLoggedIn() ? '<div class="card-title addr-title">
        <h5>addresse de livraison&nbsp;<span class="font-size-12">(Cliquer pour sélectionner)</span></h5>
        </div>' : '';
    }
}