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
        // $this->setLayout('clothes');
        // echo $this->route_params;
        // /** @var SlidersManager */
        // $model = $this->container(OrdersManager::class);
        // dd(Stringify::camelCase(implode(',', $model->getTableColumn())));
        $this->pageTitle('Modile Phones - Best Aparels Online Store');
        $this->view()->addProperties(['name' => 'Home Page']);
        $this->render('phones' . DS . 'index', $this->displayPhones(brand:2, cache: 'phones_products'));
    }

    protected function vetementsPage(array $args = []) : void
    {
        $this->pageTitle('Clothing - Best Clothes ever seen');
        $this->view()->addProperties(['name' => 'Home Clothes Page']);
        $this->render('clothes' . DS . 'clothing', $this->displayClothes(brand: 3, cache: 'clothes_products'));
    }

    protected function boutiqueVetementsPage(array $args = []) : void
    {
        $this->pageTitle('Clothing - Shop Page');
        $this->view()->addProperties(['name' => 'Shop Page']);
        $this->render('clothes' . DS . 'shop', $this->displayClothesShop(brand: 3, cache: 'clothes_products'));
    }

    protected function todoPage(array $agrs = [])
    {
        $this->view()->addProperties(['name' => 'Todo List']);
        $this->render('todoList' . DS . 'todo');
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