<?php

declare(strict_types=1);
class ValidStringValidator extends CustomValidator
{
    public function runValidation()
    {
        $getter = $this->getModel()->getEntity()->getGetters($this->getField());
        $value = $this->getModel()->getEntity()->{$getter}();

        return preg_match('/^[a-zA-Z- ]+$/', $value);
    }
}
