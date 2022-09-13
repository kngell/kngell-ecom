<?php

declare(strict_types=1);
class ValidPasswordValidator extends CustomValidator
{
    public function runValidation()
    {
        $getter = $this->getModel()->getEntity()->getGetters($this->getField());
        $value = $this->getModel()->getEntity()->{$getter}();

        return preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $value, $matches); //preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\~?!@#\$%\^&\*])(?=.{8,})/', $value);
    }
}
