<?php

declare(strict_types=1);

class UserAccountMenuController extends Controller
{
    use CheckoutControllerTrait;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function handle(array $args = []) : void
    {
        $data = $this->isValidRequest();
        if (isset($data['user_process'])) {
            $process_result = match ($data['user_process']) {
                'orders' => $this->ordersMenu($data),
               'users' => $this->usersMenu(),
               'address_book' => $this->addressBookMenu(),
               'payments_mode' => $this->paymentModeMenu()
            };
        }
    }

    protected function ordersMenu(array $data)
    {
        $ordersHtml = $this->container(ShowOrders::class, [
            'orderList' => $this->container(OrdersManager::class)->assign($data)->all(),
        ])->displayAll();
        if ($ordersHtml != '') {
            $this->jsonResponse([
                'result' => 'success',
                'msg' => ['transaction-menu' => $ordersHtml],
            ]);
        }
    }

    protected function usersMenu()
    {
    }

    protected function addressBookMenu()
    {
    }

    protected function paymentModeMenu()
    {
    }
}