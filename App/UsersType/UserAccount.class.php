<?php

declare(strict_types=1);

class UserAccount extends UsersManager
{
    protected $_table = 'user_account';
    private int $_count = 0;

    public function get(array $params = []) : self
    {
        /* @var TransactionsManager */
        if (AuthManager::isUserLoggedIn()) {
            $user = $this->container(UsersManager::class)->singleUser($this->session->get(CURRENT_USER_SESSION_NAME)['id']);
            if ($user->count() == 1) {
                $this->_count = $user->count();
                $this->assign([
                    'profile' => $this->getUserProfile($user),
                    'orders' => $this->getUserOrders($user),
                    'paymentMode' => '',
                    'address' => $this->container(AddressBookManager::class)->getUserAddress(),
                ]);
            }
        }

        return $this;
    }

    private function getUserProfile(UsersManager $userModel) : CollectionInterface
    {
        /** @var UsersEntity */
        $user = $userModel->getEntity();
        $userModel = current($userModel->get_results());

        return new Collection([
            'user_id' => $user->isInitialized('user_id') ? $user->getUserId() : '',
            'customer_id' => $user->isInitialized('customer_id') ? $user->getCustomerId() : '',
            'register_date' => $user->isInitialized('register_date') ? $user->getRegisterDate() : '',
            'updated_at' => $user->isInitialized('updated_at') ? $user->getUpdatedAt() : '',
            'deleted' => $user->isInitialized('deleted') ? $user->getDeleted() : '',
            'first_name' => $user->isInitialized('first_name') ? $user->getFirstName() : '',
            'last_name' => $user->isInitialized('last_name') ? $user->getLastName() : '',
            'phone' => $user->isInitialized('phone') ? $user->getPhone() : '',
            'email' => $user->isInitialized('email') ? $user->getEmail() : '',
            'password' => $user->isInitialized('password') ? $user->getPassword() : '',
            'profile_image' => $user->isInitialized('profile_image') ? $user->getProfileImage() : '',
            'u_function' => $userModel->u_function != null ? $userModel->u_function : '',
            'gender' => $userModel->gender != null ? $userModel->gender : '',
            'dob' => $userModel->dob != null ? $userModel->dob : '',
        ]);
    }

    private function getUserOrders(UsersManager $userModel) : CollectionInterface
    {
        /** @var UsersEntity */
        $user = $userModel->getEntity();

        return $this->container(OrdersManager::class)->assign([
            'ord_user_id' => $user->isInitialized('user_id') ? $user->getUserId() : '',
        ])->all();
    }
}
