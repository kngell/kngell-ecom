<?php

declare(strict_types=1);

trait CheckoutFromTrait
{
    protected function formElements(string $id, string $action, FormBuilder $frm) : string
    {
        $frmHtml = '';
        $frm->form([
            'action' => $action,
            'class' => [$id],
            'id' => $id,
        ]);
        $frmHtml .= $frm->begin();
        $frmHtml .= $this->frm->end();
        return $frmHtml;
    }

    protected function changeEmailForm() : string
    {
        $temp = $this->getTemplate('changeEmailformPath');
        $temp = str_replace('{{form_begin}}', $this->frm->begin(), $temp);
        $temp = str_replace('{{email}}', $this->frm->input([
            EmailType::class => ['name' => 'email', 'class' => []],
        ])->label('New Email Address')->id('chg-email')->placeholder(' ')->html(), $temp);
        $temp = str_replace('{{Button}}', $this->frm->input([
            ButtonType::class => ['type' => 'submit', 'class' => ['button']],
        ])->label('Submit')->id('submitBtnEmail')->content('Submit')->html(), $temp);
        $temp = str_replace('{{form_end}}', $this->frm->end(), $temp);
        return $temp;
    }

    protected function changeShippingFrom() : string
    {
        $temp = $this->getTemplate('changeShippingModeformPath');
        $temp = str_replace('{{form_begin}}', $this->frm->begin(), $temp);
        if ($this->shippingClass->count() > 0) {
            $default = $this->shippingClass->filter(function ($sh) {
                return $sh->default_shipping_class === '1';
            });
            if ($default->count() === 1) {
                $temp = str_replace('{{shippingModeName}}', $this->frm->input([
                    HiddenType::class => ['name' => 'sh_name', 'class' => []],
                ])->noLabel()->noWrapper()->id('sh_name')->value($default->offsetGet('0')->sh_name)->html(), $temp);
            }
        }
        $temp = str_replace('{{select_shipping_mode}}', $this->frm->input([
            SelectType::class => ['name' => 'shc_id', 'class' => []], ], $this->options())->noLabel()->id('shipping_class_change')->attr(['style' => 'width: 100%;'])->html(), $temp);

        $temp = str_replace('{{button}}', $this->frm->input([
            ButtonType::class => ['type' => 'submit', 'class' => ['button']],
        ])->label('Submit')->id('submitBtnShipping')->content('Submit')->html(), $temp);

        $temp = str_replace('{{form_end}}', $this->frm->end(), $temp);
        return $temp;
    }

    protected function options() : array
    {
        $options = [];
        if ($this->shippingClass->count() > 0) {
            $options[] = new Option(['value' => '', 'content' => '']);
            foreach ($this->shippingClass as $shipMode) {
                $options[] = new Option(['value' => $shipMode->shc_id, 'content' => $shipMode->sh_name]);
            }
        }
        return [
            $this->frm->selectOptions([], $options),
        ];
    }

    protected function AddAdressContent(string $delivery = 'N', string $billing = 'N') : string
    {
        $addAddress = $this->getTemplate('addAddressPath');

        $addAddress = str_replace('{{principale}}', $this->frm->input([
            HiddenType::class => ['name' => 'principale', 'class' => ['principale']],
        ])->noLabel()->noWrapper()->id('principale')->value($delivery)->html(), $addAddress);

        $addAddress = str_replace('{{billing_addr}}', $this->frm->input([
            HiddenType::class => ['name' => 'billing_addr', 'class' => ['billing_addr']],
        ])->noLabel()->noWrapper()->id('billing_addr')->value($billing)->html(), $addAddress);

        $addAddress = str_replace('{{pays}}', $this->frm->input([
            SelectType::class => ['name' => 'pays', 'class' => ['input-box__select', 'select_country']],
        ])->noLabel()->id('pays')->req()->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{address1}}', $this->frm->input([
            TextType::class => ['name' => 'address1'],
        ])->Label('Adresse ligne 1')->id('address1')->req()->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{address2}}', $this->frm->input([
            TextType::class => ['name' => 'address2'],
        ])->Label('Adresse ligne 2')->id('address2')->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{ville}}', $this->frm->input([
            TextType::class => ['name' => 'ville'],
        ])->Label('Ville')->id('ville')->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{region}}', $this->frm->input([
            TextType::class => ['name' => 'region'],
        ])->Label('Région/Etat')->id('region')->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{zipCode}}', $this->frm->input([
            TextType::class => ['name' => 'zip_code'],
        ])->Label('Code Postal')->id('zip_code')->req()->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{u_comment}}', $this->frm->input([
            TextAreaType::class => ['name' => 'u_comment', 'class' => ['input-box__textarea']],
        ])->Label('Commentaires, notes ...')->id('u_comment')->attr(['form' => 'user-ckeckout-frm'])->rows(2)->LabelClass(['input-box__label'])->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{useforBilling}}', $this->frm->input([
            CheckBoxType::class => ['name' => 'use_for_billing'],
        ])->Label('Utiliser cette address pour la facturation')->id('use_for_billing')->class(['checkbox__input'])->spanClass(['checkbox__box'])->LabelClass(['checkbox'])->wrapperClass(['mt-2'])->placeholder(' ')->html(), $addAddress);

        $addAddress = str_replace('{{save_for_later}}', $this->frm->input([
            CheckBoxType::class => ['name' => 'save_for_later'],
        ])->Label('Sauvegarder pour la prochaine fois')->id('save_for_later')->class(['checkbox__input'])->spanClass(['checkbox__box'])->LabelClass(['checkbox'])->wrapperClass(['mt-2'])->placeholder(' ')->html(), $addAddress);

        return $addAddress;
    }

    protected function contactInfosformElements(?object $obj = null) :  string
    {
        $uContactInfos = $this->getTemplate('contactInfosPath');
        /** @var CustomerEntity */
        $customer = $this->customer->getEntity();

        $uContactInfos = str_replace('{{userID}}', (string) $this->frm->input([
            HiddenType::class => ['name' => 'user_id'],
        ])->noLabel()->id('chk-user_id')->noWrapper()->value($customer->isInitialized('user_id') ? $customer->getUserId() : '')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{lastName}}', (string) $this->frm->input([
            TextType::class => ['name' => 'lastName'],
        ])->Label('Nom')->id('chk-lastName')->req()->placeholder(' ')->value($customer->isInitialized('lastName') ? $customer->getLastName() : '')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{firstName}}', (string) $this->frm->input([
            TextType::class => ['name' => 'firstName'],
        ])->Label('Prénom')->id('chk-firstName')->req()->placeholder(' ')->value($customer->isInitialized('firstName') ? $customer->getFirstName() : '')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{phone}}', (string) $this->frm->input([
            PhoneType::class => ['name' => 'phone'],
        ])->Label('Téléphone')->id('chk-phone')->placeholder(' ')->value($customer->isInitialized('phone') ? $customer->getPhone() : '')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{email}}', (string) $this->frm->input([
            EmailType::class => ['name' => 'email'],
        ])->Label('Email')->id('chk-email')->req()->placeholder(' ')->value($customer->isInitialized('email') ? $customer->getEmail() : '')->html(), $uContactInfos);

        return $uContactInfos;
    }

    protected function discountCode() : string
    {
        $template = $this->getTemplate('mainDiscountPath');

        $template = str_replace('{{codePromotion}}', $this->frm->input([
            TextType::class => ['name' => 'code_promotion', 'class' => ['input-box__input', 'me-2']],
        ])->Label('code promotion')->id('code_promotion__' . $this::class)->req()->placeholder(' ')->attr(['form' => 'discount-frm'])->labelClass(['input-box__label'])->html(), $template);

        $template = str_replace('{{button}}', $this->frm->input([
            ButtonType::class => ['type' => 'button', 'class' => ['btn', 'btn-highlight', 'waves-effect']],
        ])->content('Apply')->attr(['form' => 'discount-frm'])->html(), $template);

        return $template;
    }

    protected function shippingform(?object $obj) : string
    {
        $temp = $this->paths->offsetGet('shippingMethod');
        $this->isFileexists($temp);
        $temp = file_get_contents($temp);
        $html = '';
        $i = 0;
        foreach ($obj->all() as $shippingClass) {
            if ($shippingClass->status == 'on') {
                $default = $shippingClass->default_shipping_class == 1 ? true : false;
                $template = str_replace('{{shipping_method}}', $this->frm->input([
                    RadioType::class => ['name' => 'sh_name', 'class' => ['radio__input', 'me-2']],
                ])->id('sh_name' . $shippingClass->shc_id)
                    ->spanClass(['radio__radio'])
                    ->textClass(['radio__text'])
                    ->label($shippingClass->sh_name)
                    ->labelDescr($shippingClass->sh_descr)
                    ->checked($i == 0 ? $default : false)
                    ->wrapperClass(['radio-check__wrapper'])
                    ->labelClass(['radio'])
                    ->templatePath($this->paths->offsetGet('shippingRadioInpuut'))
                    ->html(), $temp);
                $template = str_replace('{{price}}', strval($this->money->getFormatedAmount(strval($shippingClass->price))) ?? '', $template);
                $html .= $template;
                $i++;
            }
        }
        return $html;
    }
}