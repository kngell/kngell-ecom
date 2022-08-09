<?php

declare(strict_types=1);

trait AddressBookTraits
{
    protected function singleAddressText(object $address) : string
    {
        $addr = '';
        if (!is_null($address)) {
            $addr .= $address->address1 . ', ';
            $addr .= $address->address2 . ', ';
            $addr .= $address->zip_code . ', ';
            $addr .= $address->ville . ', ';
            $addr .= $address->region . ', ';
            $addr .= $address->pays;
        }
        return $this->response->htmlDecode($addr);
    }

    protected function addressHtml(?string $el = null) : string
    {
        $html = '';
        $this->element($el);
        /** @var CustomerEntity */
        $customerEntity = $this->customer->getEntity();
        if ($customerEntity->isInitialized('address')) {
            foreach ($customerEntity->getAddress() as $address) {
                $temp = str_replace('{{active}}', $address->principale === 1 ? 'card--active' : '', $this->template);
                $temp = str_replace('{{id}}', $this->AddressInputId($address->ab_id), $temp);
                $temp = str_replace('{{prenom}}', $customerEntity->getFirstName() ?? '', $temp);
                $temp = str_replace('{{nom}}', $customerEntity->getLastName() ?? '', $temp);
                $temp = str_replace('{{address1}}', $address->address1 ?? '', $temp);
                $temp = str_replace('{{address2}}', $address->address2 ?? '', $temp);
                $temp = str_replace('{{code_postal}}', $address->zip_code ?? '', $temp);
                $temp = str_replace('{{ville}}', $address->ville ?? '', $temp);
                $temp = str_replace('{{region}}', $address->region ?? '', $temp);
                $temp = str_replace('{{pays}}', $address->pays ?? '', $temp);
                $temp = str_replace('{{telephone}}', $customerEntity->getPhone() ?? '', $temp);
                $temp = str_replace('{{formModify}}', $this->formManageOptions('Modifier', $address), $temp);
                $temp = str_replace('{{formErase}}', $this->formManageOptions('Supprimer', $address), $temp);
                $temp = str_replace('{{FormSelect}}', $this->formManageOptions('Selectionner', $address), $temp);
                $html .= $temp;
            }
        }
        return $html;
    }

    protected function element(?string $el = null) : void
    {
        if (null != $el && $el == 'chk-frm') {
            $this->noManageForm = true;
        } else {
            $this->noManageForm = false;
        }
    }

    protected function AddressInputId(int $id) : string
    {
        return $this->frm->input([
            HiddenType::class => ['name' => 'ab_id'],
        ])->noLabel()->noWrapper()->value($id)->html();
    }

    protected function formManageOptions(string $str, ?object $obj = null) : string
    {
        $class = match ($str) {
            'Modifier' => 'modify',
            'Supprimer' => 'erase',
            'Selectionner' => 'select'
        };
        $frmHtml = $this->frmBegin($class, $obj);
        $frmHtml .= $this->frm->input([
            HiddenType::class => ['name' => 'ab_id'],
        ])->noLabel()->noWrapper()->value($obj->ab_id ?? '')->html();
        $frmHtml .= $this->frm->input([
            ButtonType::class => ['type' => 'button', 'class' => [$class]],
        ])->noLabel()->noWrapper()->content($str != 'Selectionner' ? $str : '')->html();
        $frmHtml .= $this->frmEnd();
        return $frmHtml;
    }

    private function frmBegin(string $class, ?object $obj = null) :  string
    {
        if ($this->noManageForm === false) {
            $this->frm->form([
                'action' => '#',
                'class' => $class . $obj->ab_id,
            ])->setCsrfKey($class . $obj->ab_id);
            return $this->frm->begin();
        }
        return '';
    }

    private function frmEnd() :  string
    {
        if ($this->noManageForm === false) {
            return $this->frm->end();
        }
        return '';
    }
}