<?php

declare(strict_types=1);
abstract class AbstractFormSteps
{
    protected function accountCheckTemplate() : string
    {
        return '<div class="account-request">
                <span aria-hidden="true">Already have an account?</span>
                <a class="text-highlight" href="#" data-bs-toggle="modal"
                data-bs-target="#login-box">Login</a>
            </div>';
    }

    protected function isFileexists(string $file) : bool|string
    {
        if (!file_exists($file)) {
            return '';
        }
        return true;
    }

    protected function media(object $obj) : string
    {
        if (isset($obj->media) && count($obj->media) > 0) {
            return str_starts_with($obj->media[0], IMG) ? unserialize($obj->p_media) : IMG . unserialize($obj->media)[0];
        }
        return '';
    }
}