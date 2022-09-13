<?php

declare(strict_types=1);

trait DisplayFormElementTrait
{
    protected function options(?CollectionInterface $obj = null, ?string $valueName = null, ?string $contentName = null) : array
    {
        $options = [];
        if (!is_null($obj) && $obj->count() > 0) {
            $options[] = (new Option(['value' => '', 'content' => '']))->selected(true)->disable(true);
            foreach ($obj as $item) {
                $options[] = new Option(['value' => $item->$valueName, 'content' => $item->$contentName]);
            }
        }

        return [
            $this->frm->selectOptions([], $options),
        ];
    }
}
