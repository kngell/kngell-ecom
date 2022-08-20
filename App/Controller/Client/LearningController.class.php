<?php

declare(strict_types=1);

class LearningController extends Controller
{
    public function indexPage()
    {
        $this->render('partials' . DS . 'popup');
        // $this->render('learn' . DS . 'learn', array_merge([
        //     'text' => 'Hello world',
        // ], $this->displayUserCart()));
    }
}