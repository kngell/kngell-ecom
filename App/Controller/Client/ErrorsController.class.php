<?php

declare(strict_types=1);
class ErrorsController extends Controller
{
    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function indexPage($data)
    {
        $this->setLayout('default');
        $this->pageTitle('Errors');
        $this->view()->addProperties(['name' => 'Errors']);
        $this->render('errors' . DS . '_errors', $data);
    }

    public function userPage($data)
    {
        $this->pageTitle('Errors');
        $this->view()->addProperties(['name' => 'Errors']);
        $this->render('errors' . DS . '404', $data);
    }
}
