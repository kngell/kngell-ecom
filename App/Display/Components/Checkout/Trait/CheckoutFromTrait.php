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
            SelectType::class => ['name' => 'shc_id', 'class' => []], ], $this->options($this->shippingClass, 'shc_id', 'sh_name'))->noLabel()->id('shipping_class_change')->attr(['style' => 'width: 100%;'])->html(), $temp);

        $temp = str_replace('{{button}}', $this->frm->input([
            ButtonType::class => ['type' => 'submit', 'class' => ['button']],
        ])->label('Submit')->id('submitBtnShipping')->content('Submit')->html(), $temp);

        $temp = str_replace('{{form_end}}', $this->frm->end(), $temp);

        return $temp;
    }

    protected function contactInfosformElements(?object $obj = null) :  string
    {
        $uContactInfos = $this->getTemplate('contactInfosPath');

        $uContactInfos = str_replace('{{userID}}', (string) $this->frm->input([
            HiddenType::class => ['name' => 'user_id'],
        ])->noLabel()->id('chk-user_id')->noWrapper()->value($this->customerEntity->isInitialized('user_id') ? $this->customerEntity->getUserId() : '')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{lastName}}', (string) $this->frm->input([
            TextType::class => ['name' => 'lastName'],
        ])->Label('Nom')->id('chk-lastName')->req()->placeholder(' ')->value($this->customerEntity->isInitialized('lastName') ? $this->customerEntity->getLastName() : '')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{firstName}}', (string) $this->frm->input([
            TextType::class => ['name' => 'firstName'],
        ])->Label('Prénom')->id('chk-firstName')->req()->placeholder(' ')->value($this->customerEntity->isInitialized('firstName') ? $this->customerEntity->getFirstName() : '')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{phone}}', (string) $this->frm->input([
            PhoneType::class => ['name' => 'phone'],
        ])->Label('Téléphone')->id('chk-phone')->placeholder(' ')->value($this->customerEntity->isInitialized('phone') ? $this->customerEntity->getPhone() : '')->html(), $uContactInfos);

        $uContactInfos = str_replace('{{email}}', (string) $this->frm->input([
            EmailType::class => ['name' => 'email'],
        ])->Label('Email')->id('chk-email')->req()->placeholder(' ')->value($this->customerEntity->isInitialized('email') ? $this->customerEntity->getEmail() : '')->html(), $uContactInfos);

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
