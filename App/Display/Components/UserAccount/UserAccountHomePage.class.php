<?php

declare(strict_types=1);

class UserAccountHomePage extends AbstractUserAccount implements DisplayPagesInterface
{
    public function __construct(array $params, ?FormBuilder $frm, UserAccountPaths $paths, CustomReflector $reflect)
    {
        parent::__construct(array_merge($params, [
            'frm' => $frm,
            'paths' => $paths->paths(),
            'reflect' => $reflect,
        ]));
    }

    public function displayAll(): mixed
    {
        return [
            'user_profile' => $this->userProfile(),
            'user_payment_card' => $this->userTransaction(),
            'buttons' => $this->buttons(),
        ];
    }

    private function userProfile() : string
    {
        $en = $this->customerEntity;
        $template = $this->getTemplate('userMiniProfilePath');
        $template = str_replace('{{userIdentification}}', $this->user(), $template);
        $template = str_replace('{{profile_image}}', $en->isInitialized('profile_image') ? $en->getProfileImage() : '', $template);
        $template = str_replace('{{firstName}}', $en->isInitialized('first_name') ? $en->getFirstName() : '', $template);
        $template = str_replace('{{lastName}}', $en->isInitialized('last_name') ? $en->getLastName() : '', $template);
        $template = str_replace('{{Email}}', $en->isInitialized('email') ? $en->getEmail() : '', $template);
        $template = str_replace('{{profile_link}}', $this->params['links']['profile'], $template);
        $template = str_replace('{{orders_link}}', $this->params['links']['orders'], $template);
        $template = str_replace('{{address_link}}', $this->params['links']['address'], $template);
        $template = str_replace('{{user_card_link}}', $this->params['links']['card'], $template);
        $template = str_replace('{{remove_account_frm}}', $this->removeAccountButton(), $template);
        $template = str_replace('{{account_route}}', '/account', $template);
        return $template;
    }

    private function userTransaction() : string
    {
        $template = $this->getTemplate('transactionPath');
        list($content, $pagination) = $this->userTransactionItems();
        $template = str_replace('{{usercard}}', $this->userPaymentCard(), $template);
        $template = str_replace('{{transaction_content}}', $content, $template);
        $template = str_replace('{{transaction_footer}}', $pagination, $template);
        $template = str_replace('{{add_address_modal}}', isset($this->addAddressModal) ? $this->addAddressModal : '', $template);
        return $template;
    }

    private function userTransactionItems() : array
    {
        return match (true) {
            $this->reflect->isInitialized('showOrders', $this) => [
                $this->showOrders->displayAll(),
                $this->pagination->displayAll(),
            ],
            $this->reflect->isInitialized('profile', $this) => [
                $this->profile->setUserProfile(AuthManager::currentUser()->getEntity())->displayAll(), '',
            ],
            $this->reflect->isInitialized('showAddress', $this) => $this->showAddress(),
            $this->reflect->isInitialized('userCard', $this) => [
                $this->userCard->setCustomer($this->customerEntity)->displayAll(), '',
            ],
        };
    }

    private function showAddress()
    {
        list($addressBook, $this->addAddressModal) = $this->showAddress->setCustomer($this->customerEntity)->displayAll();

        return [
            $addressBook, '',
        ];
    }

    private function userPaymentCard() : string
    {
        $template = $this->getTemplate('userCardPaymentPath');
        $template = str_replace('{{credit_card__head_items}}', $this->cardHead(), $template);
        $templateTableNames = ['orders', 'users', 'address_book', 'payments_mode'];
        $temp = '';
        foreach ($templateTableNames as $key => $name) {
            if ($key === array_key_first($templateTableNames)) {
                $temp = str_replace('{{user_form_' . $name . '}}', $this->userForm($name), $template);
            } else {
                $temp = str_replace('{{user_form_' . $name . '}}', $this->userForm($name), $temp);
            }
        }

        return $temp;
    }

    private function cardHead() : string
    {
        $cardItemHtml = '';
        $template = $this->getTemplate('userCcHeadItemPath');
        if ($this->customerEntity->isInitialized('user_cards')) {
            $cardList = $this->customerEntity->getUserCards()->data;
            if (count($cardList) > 0) {
                foreach ($cardList as $card) {
                    $temp = str_replace('{{image}}', ImageManager::asset_img('users/account/account_mastercard.png'), $template);
                    $temp = str_replace('{{name}}', $card->name ?? '', $temp);
                    $temp = str_replace('{{last4}}', $card->last4, $temp);
                    $temp = str_replace('{{expiry}}', $card->exp_month . '/' . $card->exp_year, $temp);
                    $cardItemHtml .= $temp;
                }
            }
        }
        return $cardItemHtml;
    }

    private function buttons() : string
    {
        $template = $this->getTemplate('buttonsPath');
        $template = str_replace('{{route}}', '/shop', $template);

        return $template;
    }
}