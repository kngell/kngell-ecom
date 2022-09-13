<?php

declare(strict_types=1);
class MatchesValidator extends CustomValidator
{
    public function runValidation()
    {
        $getter = $this->getModel()->getEntity()->getGetters($this->getField());
        $value = $this->getModel()->getEntity()->{$getter}();

        return $value == $this->getModel()->getEntity()->{'get' . ucwords($this->getRule())}();
    }
}
