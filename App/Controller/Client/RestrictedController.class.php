<?php

declare(strict_types=1);

class RestrictedController extends Controller
{
    public function loginPage(array $args = []) : void
    {
        $this->render('restricted' . DS . 'index', $this->displayLayout());
    }
}