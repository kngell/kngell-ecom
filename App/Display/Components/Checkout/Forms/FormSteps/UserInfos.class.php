<?php

declare(strict_types=1);

class UserInfos extends AbstractCheckoutformSteps implements CheckoutFormStepInterface
{
    private string $title = 'Paiement Informations';

    public function __construct(protected ?object $frm, protected ?object $obj, protected ?ButtonsGroup $btns, protected ?CartSummary $summary, protected ?CollectionInterface $paths = null)
    {
        $this->frm->globalClasses([
            'wrapper' => [],
            'input' => ['input-box__input'],
            'label' => ['input-box__label'],
        ]);
    }

    public function display() : string
    {
        $mainTemplate = $this->paths->offsetGet('mainUserTemplate');
        $userData = $this->paths->offsetGet('userDataPath');
        if ((!file_exists($mainTemplate) || !file_exists($userData)) || is_null($this->obj)) {
            return '';
        }
        return $this->outputTemplate(file_get_contents($mainTemplate), file_get_contents($userData), $this->obj);
    }

    protected function titleTemplate(string $title = '') : string
    {
        $contactTitle = $this->paths->offsetGet('contactTitlePath');
        $this->isFileexists($contactTitle);
        return str_replace('{{accountCheckt}}', !AuthManager::isUserLoggedIn() ? '<div class="account-request">
        <span aria-hidden="true">Already have an account?</span>
        <a class="text-highlight" href="#" data-bs-toggle="modal" data-bs-target="#login-box">Login</a>
        </div>' : '', file_get_contents($contactTitle));
    }

    private function outputTemplate(string $template = '', string $dataTemplate = '', ?Object $obj = null) : string
    {
        $temp = '';
        if (!is_null($obj) && $obj->count() > 0) {
            $temp = str_replace('{{userCartSummary}}', $this->summary->display($this), $template);
            $temp = str_replace('{{data}}', $dataTemplate, $temp);
            $temp = str_replace('{{title}}', $this->titleTemplate(), $temp);
            $temp = str_replace('{{discountCode}}', $this->discountCode(), $temp);
            $temp = str_replace('{{contactContent}}', $this->contactInfosTemplate($obj), $temp);
            // $temp = str_replace('{{deliveryAddress}}', $this->deliveryAdressTemplate($obj), $temp);
            $temp = str_replace('{{buttons_group}}', $this->buttons(), $temp);
        }
        return $temp;
    }

    private function contactInfosTemplate(?object $obj = null) :  string
    {
        $uContactInfos = $this->paths->offsetGet('contactInfosPath');

        $this->isFileexists($uContactInfos);
        $uContactInfos = file_get_contents($uContactInfos);
        $uContactInfos = str_replace('{{lastName}}', (string) $this->frm->input([
            TextType::class => ['name' => 'lastName'],
        ])->Label('Nom')->id('chk-lastName')->req()->placeholder(' ')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{firstName}}', (string) $this->frm->input([
            TextType::class => ['name' => 'firstName'],
        ])->Label('Prénom')->id('chk-firstName')->req()->placeholder(' ')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{phone}}', (string) $this->frm->input([
            PhoneType::class => ['name' => 'phone'],
        ])->Label('Téléphone')->id('chk-phone')->placeholder(' ')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{email}}', (string) $this->frm->input([
            EmailType::class => ['name' => 'email'],
        ])->Label('Email')->id('chk-email')->req()->placeholder(' ')->html(), $uContactInfos);

        return $uContactInfos;
    }
}