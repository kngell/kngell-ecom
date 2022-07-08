<?php

declare(strict_types=1);

class UserInfos extends AbstractCheckout implements CheckoutFormStepInterface
{
    public function __construct(protected ?object $frm, protected ?object $obj, protected ?ButtonsGroup $btns, protected ?string $summary, protected ?CollectionInterface $paths = null)
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
        return $this->outputUserInfosTemplate(file_get_contents($mainTemplate), file_get_contents($userData), $this->obj);
    }

    private function outputUserInfosTemplate(string $template = '', string $dataTemplate = '', ?Object $obj = null) : string
    {
        $temp = '';
        if (!is_null($obj) && $obj->count() > 0) {
            $temp = str_replace('{{userCartSummary}}', $this->summary, $template);
            $temp = str_replace('{{userInfoAndData}}', $dataTemplate, $temp);
            $temp = str_replace('{{contactTitle}}', $this->contactTitleTemplate(), $temp);
            $temp = str_replace('{{contactContent}}', $this->contactInfosTemplate($obj), $temp);
            $temp = str_replace('{{deliveryAddress}}', $this->deliveryAdressTemplate($obj), $temp);
            $temp = str_replace('{{discountCode}}', $this->discountCode(), $temp);
            $temp = str_replace('{{buttonsRight}}', $this->btns->buttonsGroup('next'), $temp);
            $temp = str_replace('{{buttonsLeft}}', $this->btns->buttonsGroup('prev'), $temp);
        }
        return $temp;
    }

    private function contactTitleTemplate() : string
    {
        $contactTitle = $this->paths->offsetGet('contactTitlePath');
        $this->isFileexists($contactTitle);
        return str_replace('{{accountCheckt}}', AuthManager::isUserLoggedIn() ? '<div class="account-request">
        <span aria-hidden="true">Already have an account?</span>
        <a class="text-highlight" href="#" data-bs-toggle="modal" data-bs-target="#login-box">Login</a>
        </div>' : '', file_get_contents($contactTitle));
    }

    private function deliveryAdressTemplate(?object $obj = null) : string
    {
        $uDeliveryAdress = $this->paths->offsetGet('deliveryAddressPath');
        $this->isFileexists($uDeliveryAdress);
        $uDeliveryAdress = file_get_contents($uDeliveryAdress);
        $uDeliveryAdress = str_replace('{{pays}}', $this->frm->input([
            SelectType::class => ['name' => 'pays', 'class' => ['input-box__select', 'select_country']],
        ])->noLabel()->id('pays')->req()->placeholder(' ')->html(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{address1}}', $this->frm->input([
            TextType::class => ['name' => 'address1'],
        ])->Label('Adresse ligne 1')->id('address1')->req()->placeholder(' ')->html(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{address2}}', $this->frm->input([
            TextType::class => ['name' => 'address2'],
        ])->Label('Adresse ligne 2')->id('address2')->placeholder(' ')->html(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{ville}}', $this->frm->input([
            TextType::class => ['name' => 'ville'],
        ])->Label('Ville')->id('ville')->placeholder(' ')->html(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{region}}', $this->frm->input([
            TextType::class => ['name' => 'region'],
        ])->Label('Région/Etat')->id('region')->placeholder(' ')->html(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{zipCode}}', $this->frm->input([
            TextType::class => ['name' => 'zip_code'],
        ])->Label('Code Postal')->id('zip_code')->req()->placeholder(' ')->html(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{u_comment}}', $this->frm->input([
            TextAreaType::class => ['name' => 'u_comment', 'class' => ['input-box__textarea']],
        ])->Label('Commentaires, notes ...')->id('u_comment')->attr(['form' => 'user-ckeckout-frm'])->rows(2)->LabelClass(['input-box__label'])->placeholder(' ')->html(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{checkout-remember-me}}', $this->frm->input([
            CheckBoxType::class => ['name' => 'checkout-remember-me'],
        ])->Label('Sauvegarder ces informations pour la prochaine fois')->id('checkout-remember-me')->class(['checkbox__input'])->spanClass(['checkbox__box'])->LabelClass(['checkbox'])->wrapperClass(['mt-2'])->req()->placeholder(' ')->html(), $uDeliveryAdress);

        return $uDeliveryAdress;
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