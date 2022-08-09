<?php

declare(strict_types=1);
class MinValidator extends CustomValidator
{
    public function runValidation()
    {
        $getter = $this->getModel()->getEntity()->getGetters($this->getField());
        $value = $this->getModel()->getEntity()->{$getter}();
        $pass = (strlen($value) >= $this->getRule());
        return $pass;
    }
}