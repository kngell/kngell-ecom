<?php

declare(strict_types=1);
class PaymentModeManager extends Model
{
    protected $_colID = 'pm_id';
    protected $_table = 'payment_mode';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }

    public function all()
    {
        $this->table()->return('object');

        return new Collection($this->getAll()->get_results());
    }
}
