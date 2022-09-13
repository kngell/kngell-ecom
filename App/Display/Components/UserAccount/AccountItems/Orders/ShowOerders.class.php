<?php

declare(strict_types=1);

class ShowOrders extends AbstractShowOrders implements DisplayPagesInterface
{
    public function __construct(CollectionInterface $orderList, UserAccountPaths $paths)
    {
        parent::__construct($orderList, $paths);
    }

    public function displayAll(): mixed
    {
        return $this->showAllOrders();
    }

    protected function showAllOrders()
    {
        $template = $this->getTemplate('showOrdersPath');
        $html = '';
        if ($this->orderList->count() > 0) {
            $orderList = $this->orderList->offsetGet('orders');
            foreach ($orderList as $order) {
                $temp = str_replace('{{ord_date}}', $order->created_at, $template);
                $temp = str_replace('{{ord_ttc}}', $order->ord_amount_ttc, $temp);
                $temp = str_replace('{{ord_userFullName}}', $order->first_name . '&nbsp;' . $order->last_name, $temp);
                $temp = str_replace('{{ord_number}}', $order->ord_number, $temp);
                $temp = str_replace('{{ord_deliveryDate}}', $order->ord_delivery_date, $temp);
                $temp = str_replace('{{ord_status}}', (string) $order->status, $temp);
                $temp = str_replace('{{ord_itemInfos}}', $this->orderDetailsInfos($order), $temp);
                $html .= $temp;
            }
        }

        return $html;
    }
}
