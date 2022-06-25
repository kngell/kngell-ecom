<?php

declare(strict_types=1);
class CartManager extends Model
{
    protected string $_colID = 'cart_id';
    protected string $_table = 'cart';
    protected $_colIndex = 'user_id';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }

    public function addUserItem() : array
    {
        if ($this->cookie->exists(VISITOR_COOKIE_NAME)) {
            $this->table(null, ['COUNT|cart_id|nbItems'])->where([
                'user_id' => $this->cookie->get(VISITOR_COOKIE_NAME),
                'item_id' => $this->entity->getFieldValue('item_id'),
            ])->return('current');
            $userCart = new Collection(current($this->getAll()->get_results()));
            if ($userCart->offsetGet('nbItems') == 0) {
                $this->assign([
                    'user_id' => $this->cookie->get(VISITOR_COOKIE_NAME),
                ])->save();
                return ['nbItems' => 1];
            }
        }
        return ['nbItems' => 0];
    }

    public function getUserCart()
    {
        if ($this->cookie->exists(VISITOR_COOKIE_NAME)) {
            $this->table()->where(['user_id' => $this->cookie->get(VISITOR_COOKIE_NAME)])
                ->return('object');
            return new Collection($this->getAll()->get_results());
        }
        return new Collection([]);
    }
}