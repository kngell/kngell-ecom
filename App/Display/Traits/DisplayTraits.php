<?php

declare(strict_types=1);

trait DisplayTraits
{
    protected function invoke(array $args = []) : array
    {
        $resp = [];
        if (!empty($args)) {
            foreach ($args as $arg) {
                if ($arg instanceof Closure) {
                    $resp[] = $arg->__invoke();
                }
            }
        }
        return $resp;
    }

    protected function isFileexists(string $file) : bool
    {
        if (!file_exists($file)) {
            throw new BaseException('File does not exist!', 1);
        }
        return true;
    }

    protected function getTemplate(string $path) : string
    {
        $this->isFileexists($this->paths->offsetGet($path));
        return file_get_contents($this->paths->offsetGet($path));
    }
}