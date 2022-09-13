<?php

declare(strict_types=1);
class ValidDomainValidator extends CustomValidator
{
    public function runValidation()
    {
        $getter = $this->getModel()->getEntity()->getGetters($this->getField());
        $value = $this->getModel()->getEntity()->{$getter}();

        return checkdnsrr(substr($value, strpos($value, '@') + 1), 'MX');
    }
}
