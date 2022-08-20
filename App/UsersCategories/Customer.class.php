<?php

declare(strict_types=1);

class Customer extends UsersManager
{
    protected $_table = 'customer';
    private int $_count;

    public function get() : self
    {
        /* @var TransactionsManager */
        if (AuthManager::isUserLoggedIn() && !$this->session->exists(CHECKOUT_PROCESS_NAME)) {
            $user = AuthManager::currentUser();
            if ($user->count() == 1) {
                $this->_count = $user->count();
                /** @var UsersEntity */
                $user = $user->getEntity();
                $this->assign([
                    'user_id' => $user->isInitialized('user_id') ? $user->getUserId() : '',
                    'order_id' => $this->container->make(TransactionsManager::class)->getUniqueId('order_id', 'ORD-', '-0XKF', 6),
                    'first_name' => $user->isInitialized('first_name') ? $user->getFirstName() : '',
                    'last_name' => $user->isInitialized('last_name') ? $user->getLastName() : '',
                    'phone' => $user->isInitialized('phone') ? $user->getPhone() : '',
                    'email' => $user->isInitialized('email') ? $user->getEmail() : '',
                    'address' => $this->container->make(AddressBookManager::class)->getUserAddress(),
                ]);
            }
        }
        return $this;
    }

    public function count(): int
    {
        return isset($this->_count) ? $this->_count : 0;
    }
}