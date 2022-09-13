<?php

declare(strict_types=1);
class LoginAttemptsManager extends Model
{
    protected $_colID = 'la_id';
    protected $_table = 'login_attempts';
    protected $_colIndex = 'user_id';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }
}
