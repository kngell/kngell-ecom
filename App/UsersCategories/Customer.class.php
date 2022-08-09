<?php

declare(strict_types=1);

class Customer extends UsersManager
{
    protected $_table = 'customer';
    private int $_count;

    public function get() : self
    {
        if (AuthManager::isUserLoggedIn()) {
            /** @var UsersEntity */
            $user = (object) AuthManager::currentUser()->getEntity()->getInitializedAttributes();
            $this->assign([
                'user_id' => $user->user_id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'phone' => $user->phone,
                'email' => $user->email,
                'address' => $this->container->make(AddressBookManager::class)->getUserAddress(),
            ]);
            $this->_count = AuthManager::$currentLoggedInUser->count();
        }
        return $this;
    }

    public function count(): int
    {
        return isset($this->_count) ? $this->_count : 0;
    }
}