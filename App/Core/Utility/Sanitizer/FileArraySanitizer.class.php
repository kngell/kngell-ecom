<?php

declare(strict_types=1);

final class FileArraySanitizer
{
    private const FILES_FIELDS = ['name', 'type', 'tmp_name', 'error', 'size'];

    private function __construct()
    {
    }

    public static function sanitize(array $fileAry) : array
    {
        if (!empty(array_diff(self::FILES_FIELDS, array_keys($fileAry))) || !is_array($fileAry['name'])) {
            return $fileAry;
        }
        $sanitized = [];
        for ($i = 0; $i < count($fileAry['name']); $i++) {
            $file = [];
            foreach (self::FILES_FIELDS as $field) {
                $file[$field] = $fileAry[$field][$i];
            }
            $sanitized[] = $file;
        }

        return $sanitized;
    }
}
