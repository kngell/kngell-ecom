<?php

declare(strict_types=1);

class UserAccountHomePage extends AbstractUserAccount implements DisplayPagesInterface
{
    public function __construct(CollectionInterface $orderList, FormBuilder $frm, UserAccountPaths $paths)
    {
        parent::__construct($orderList, $frm, $paths);
    }

    public function displayAll(): mixed
    {
        return [
            'user_profile' => $this->userProfile(),
            'user_payment_card' => $this->userPaymentCard(),
            'buttons' => $this->buttons(),
        ];
    }

    private function userProfile() : string
    {
        $template = $this->getTemplate('userProfilePath');
        $template = str_replace('{{userIdentification}}', $this->user($this->en), $template);
        $template = str_replace('{{profile_image}}', $this->en->getProfileImage(), $template);
        $template = str_replace('{{firstName}}', $this->en->getFirstName(), $template);
        $template = str_replace('{{lastName}}', $this->en->getLastName(), $template);
        $template = str_replace('{{Email}}', $this->en->getEmail(), $template);
        $template = str_replace('{{remove_account_frm}}', $this->removeAccountButton(), $template);
        $template = str_replace('{{account_route}}', '/account', $template);
        return $template;
    }

    private function userPaymentCard() : string
    {
        $template = $this->getTemplate('userCardPaymentPath');
        $templateTableNames = ['orders', 'users', 'address_book', 'payments_mode'];
        $temp = '';
        foreach ($templateTableNames as $key => $name) {
            if ($key === array_key_first($templateTableNames)) {
                $temp = str_replace('{{user_form_' . $name . '}}', $this->userForm($name), $template);
            } else {
                $temp = str_replace('{{user_form_' . $name . '}}', $this->userForm($name), $temp);
            }
        }
        $temp = str_replace('{{orderList}}', $this->showOrderList(), $temp);
        $temp = str_replace('{{pagination}}', $this->pagination(), $temp);
        return $temp;
    }

    private function buttons() : string
    {
        $template = $this->getTemplate('buttonsPath');
        $template = str_replace('{{route}}', '/shop', $template);
        return $template;
    }
}