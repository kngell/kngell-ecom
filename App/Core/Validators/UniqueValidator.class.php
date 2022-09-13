<?php

declare(strict_types=1);
class UniqueValidator extends CustomValidator
{
    public function runValidation()
    {
        $field = (is_array($this->getField())) ? $this->getField()[0] : $this->getField();
        $en = $this->getModel()->getEntity();
        $getter = $en->getGetters($this->getField());
        $value = $en->{$getter}();
        $this->getModel()->table()->where([$field => $value])->return('class');
        $other = $this->getModel()->getAll();
        $table_id = $this->getModel()->getTableSchemaID() ?? null;
        if ($other->count() <= 0) {
            return true;
        }
        if (( new ReflectionProperty($en, $en->getColId('id', true)))->isInitialized($en)) {
            foreach ($other->get_results() as $item) {
                if (isset($table_id) && $item->$table_id == $en->{$en->getGetters($en->getColId())}()) {
                    return true;
                }
            }
        }

        return !$other->count() >= 1;
    }
}
