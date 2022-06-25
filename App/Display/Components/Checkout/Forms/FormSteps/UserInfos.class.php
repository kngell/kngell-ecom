<?php

declare(strict_types=1);

class UserInfos extends AbstractFormSteps
{
    public function __construct(private ?object $frm = null, private ?object $obj = null)
    {
    }

    public function userInfos() : string
    {
        $uTemplate = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS . '_chk_user_info.php';
        $uDataTemplate = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS . '_user_data.php';
        if ((!file_exists($uTemplate) || !file_exists($uDataTemplate)) || is_null($this->obj)) {
            return '';
        }
        return $this->outputUserInfosTemplate(file_get_contents($uTemplate), file_get_contents($uDataTemplate), $this->obj);
    }

    private function outputUserInfosTemplate(string $template = '', string $dataTemplate = '', ?Object $obj = null) : string
    {
        $temp = '';
        if ($obj->count() > 0) {
            $temp = str_replace('{{userCartSummary}}', $this->userCartSummary($obj), $template);
            $temp = str_replace('{{userInfoAndData}}', $dataTemplate, $temp);
            $temp = str_replace('{{accountCheck}}', AuthManager::isUserLoggedIn() ? $this->accountCheckTemplate($obj) : '', $temp);
            $temp = str_replace('{{contactInfos}}', $this->contactInfosTemplate($obj), $temp);
            $temp = str_replace('{{deliveryAddress}}', $this->deliveryAdressTemplate($obj), $temp);
        }
        return $temp;
    }

    private function userCartSummary(?object $obj = null) : string
    {
        $uCartSummary = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS . '_card_summary.php';
        $this->isFileexists($uCartSummary);
        $uCartSummary = file_get_contents($uCartSummary);
        $uCartSummary = str_replace('{{cartSummaryContent}}', $this->cartSummaryContent($obj), $uCartSummary);
        $uCartSummary = str_replace('{{CartSummaryTotal}}', $this->cartSummaryTotal($obj), $uCartSummary);
        return $uCartSummary;
    }

    private function cartSummaryTotal(?object $obj = null) : string
    {
        $uCartSummaryTotal = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS . '_cartSummaryTotal.php';
        $this->isFileexists($uCartSummaryTotal);
        $uCartSummaryTotal = file_get_contents($uCartSummaryTotal);
        $uCartSummaryTotal = str_replace('{{totalHT}}', $ht ?? '', $uCartSummaryTotal);
        $uCartSummaryTotal = str_replace('{{reduction}}', $reduction ?? '', $uCartSummaryTotal);
        $uCartSummaryTotal = str_replace('{{taxes}}', $taxes ?? '', $uCartSummaryTotal);
        $uCartSummaryTotal = str_replace('{{totalTTC}}', $ttc ?? '', $uCartSummaryTotal);
        return $uCartSummaryTotal;
    }

    private function cartSummaryContent(object $obj) : string
    {
        $temp = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS . '_cart_summary_content.php';
        $this->isFileexists($temp);
        $temp = file_get_contents($temp);
        $template = '';
        foreach ($obj as $product) {
            if ($product->cart_type == 'cart') {
                $uCartSummaryContent = str_replace('{{image}}', $this->media($product), $temp);
                $uCartSummaryContent = str_replace('{{Quantity}}', strval($product->item_qty), $uCartSummaryContent);
                $uCartSummaryContent = str_replace('{{title}}', $product->p_title ?? '', $uCartSummaryContent);
                $uCartSummaryContent = str_replace('{{color}}', $product->p_color ?? '', $uCartSummaryContent);
                $sep = isset($product->p_color) && isset($product->p_size);
                $uCartSummaryContent = str_replace('{{separator}}', $sep && ($product->p_color != null || $product->p_size != null) ? ' / ' : '', $uCartSummaryContent);
                $uCartSummaryContent = str_replace('{{size}}', $product->size ?? '', $uCartSummaryContent);
                $uCartSummaryContent = str_replace('{{price}}', $product->price ?? '', $uCartSummaryContent);
                $template .= $uCartSummaryContent;
            }
        }
        return $template;
    }

    private function deliveryAdressTemplate(?object $obj = null) : string
    {
        $uDeliveryAdress = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS . '_checkout_delivery_address.php';
        $this->isFileexists($uDeliveryAdress);
        $uDeliveryAdress = file_get_contents($uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{pays}}', (string) $this->frm->input([
            SelectType::class => ['name' => 'pays'],
        ])->Label('Pays')->id('pays')->class('select_country')->req(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{address1}}', (string) $this->frm->input([
            TextType::class => ['name' => 'address1'],
        ])->Label('Adresse ligne 1')->id('address1')->req(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{address2}}', (string) $this->frm->input([
            TextType::class => ['name' => 'address2'],
        ])->Label('Adresse ligne 2')->id('address2')->req(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{ville}}', (string) $this->frm->input([
            TextType::class => ['name' => 'ville'],
        ])->Label('Ville')->id('ville')->req(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{region}}', (string) $this->frm->input([
            TextType::class => ['name' => 'region'],
        ])->Label('Région/Etat')->id('region'), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{zipCode}}', (string) $this->frm->input([
            TextType::class => ['name' => 'zip_code'],
        ])->Label('Code Postal')->id('zip_code')->req(), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{u_comment}}', (string) $this->frm->input([
            TextAreaType::class => ['name' => 'u_comment'],
        ])->Label('Commentaires, notes ...')->id('u_comment')->attr(['form' => 'user-ckeckout-frm'])->rows(3)->class('input-box__textarea'), $uDeliveryAdress);

        $uDeliveryAdress = str_replace('{{checkout-remember-me}}', (string) $this->frm->input([
            CheckBoxType::class => ['name' => 'checkout-remember-me'],
        ])->Label('Sauvegarder ces informations pour la prochaine fois')->id('checkout-remember-me')->class('checkbox__input')->spanClass('checkbox__box')->LabelClass('checkbox')->wrapperClass('mt-2'), $uDeliveryAdress);

        return $uDeliveryAdress;
    }

    private function contactInfosTemplate(?object $obj = null) :  string
    {
        $uContactInfos = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS . '_checkout_contact_infos.php';
        $this->isFileexists($uContactInfos);

        $uContactInfos = file_get_contents($uContactInfos);
        $uContactInfos = str_replace('{{lastName}}', (string) $this->frm->input([
            TextType::class => ['name' => 'lastName'],
        ])->Label('Nom')->id('chk-lastName')->req(), $uContactInfos);

        $uContactInfos = str_replace('{{firstName}}', (string) $this->frm->input([
            TextType::class => ['name' => 'firstName'],
        ])->Label('Prénom')->id('chk-firstName')->req(), $uContactInfos);

        $uContactInfos = str_replace('{{phone}}', (string) $this->frm->input([
            PhoneType::class => ['name' => 'phone'],
        ])->Label('Téléphone')->id('chk-phone')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{email}}', (string) $this->frm->input([
            EmailType::class => ['name' => 'email'],
        ])->Label('Email')->id('chk-email')->req(), $uContactInfos);

        return $uContactInfos;
    }
}