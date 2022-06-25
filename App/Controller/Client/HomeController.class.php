<?php

declare(strict_types=1);
class HomeController extends Controller
{
    use HomeControllerTrait;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    /**
     * IndexPage
     * ===================================================================.
     * @param array $data
     * @return void
     */
    protected function indexPage(array $data = []) : void
    {
        $this->setLayout('clothes');
        $this->pageTitle('Clothing - Best Aparels Online Store');
        $this->view()->addProperties(['name' => 'Home Page']);
        $this->render('checkout' . DS . 'checkout', $this->homePage());
    }

    /**
     * IndexPage
     * ===================================================================.
     * @param array $data
     * @return void
     */
    protected function libPage(array $data = []) : void
    {
        $this->setLayout('clothes');
        $this->pageTitle('Clothing - Best Aparels Online Store');
        $this->view()->addProperties(['name' => 'Home Page']);
        $this->render('home' . DS . 'lib');
    }
}