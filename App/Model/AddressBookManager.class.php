<?php

declare(strict_types=1);
class AddressBookManager extends Model
{
    protected $_colID = 'ab_id';
    protected $_table = 'address_book';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }

    public function getUserAddress() : CollectionInterface
    {
        if (AuthManager::isUserLoggedIn()) {
            $this->table()->where(['tbl' => 'users', 'rel_id' => $this->session->get(CURRENT_USER_SESSION_NAME)['id']])->return('object');
            $add = $this->getAll()->get_results();
            return new Collection($add);
        }
        return new Collection([]);
    }

    public function save(?Entity $entity = null) : ?self
    {
        if (AuthManager::isUserLoggedIn()) {
            // $this->assign(['tbl' => 'users', 'rel_id' => $this->session->get(CURRENT_USER_SESSION_NAME)['id']]);
            return parent::save();
        }
        return $this;
    }
}