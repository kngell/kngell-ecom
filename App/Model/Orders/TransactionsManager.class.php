<?php

declare(strict_types=1);

class TransactionsManager extends Model
{
    protected string $_colID = 'tr_id';
    protected string $_table = 'transactions';
    protected $_colIndex = 'user_id';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }
}
