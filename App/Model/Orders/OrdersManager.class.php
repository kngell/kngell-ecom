<?php

declare(strict_types=1);

class OrdersManager extends Model
{
    protected $_colID = 'ord_id';
    protected $_table = 'orders';
    protected $_colIndex = 'ord_user_id';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }

    public function all() : CollectionInterface
    {
        /** @var OrdersEntity */
        $en = $this->getEntity();
        if ($en->isInitialized('ord_user_id')) {
            $this->table()
                ->leftJoin('users', ['first_name', 'last_name'])
                ->join('order_details')
                ->leftJoin('products', ['title', 'short_descr', 'media'])
                ->leftJoin('order_status', ['status'])
                ->on(['ord_user_id|orders', 'user_id|users'], ['ord_id|orders', 'od_order_id|order_details'], ['od_product_id|order_details', 'pdt_id|products'], ['ord_status|orders', 'os_id|order_status'])
                ->where([$this->_colIndex => $en->getOrdUserId()])
                ->return('object');
            return new Collection($this->getAll()->get_results());
        }
        return new Collection();
    }

    public function AllWithSearchAndPagin(array $params = []) : CollectionInterface
    {
        /** @var OrdersEntity */
        $en = $this->getEntity();
        if ($en->isInitialized('ord_user_id')) {
            $this->table()
                ->leftJoin('users', ['first_name', 'last_name'])
                ->leftJoin('order_status', ['status'])
                ->on(['ord_user_id|orders', 'user_id|users'], ['ord_status|orders', 'os_id|order_status'])
                ->where([$this->_colIndex => $en->getOrdUserId()])
                ->parameters(['limit' => 3, 'offset' => 0])
                ->return('object');
            $r = $this->getAllWithSearchAndPagin($params)->get_results();
            $orders = $r['results'];
            unset($r['results']);
            $keys = array_unique(array_column($orders, 'ord_id'));
            return new Collection([
                'orders' => new Collection($orders),
                'order_details' => $this->container(OrderDetailsManager::class)->getOrderDetails($keys),
                'params' => array_merge($r, $params),
            ]);
        }
        return new Collection();
    }
}