<?php

declare(strict_types=1);

class OrderStatusManager extends Model
{
    protected $_colID = 'os_id';
    protected $_table = 'order_status';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }
}
