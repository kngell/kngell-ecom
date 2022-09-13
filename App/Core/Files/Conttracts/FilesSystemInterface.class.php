<?php

declare(strict_types=1);
interface FilesSystemInterface
{
    public function get(string $folder, string $file = '') : mixed;

    public function createDir(string $folder) : bool;

    public function createDirectory(string $directory) : void;

    public function search_file(string $folder, ?string $file_to_search = null, ?string $subFolder = '', array &$results = []) : array;
}
