<?php

declare(strict_types=1);

abstract class AbstractShowOrders
{
    use DisplayTraits;

    protected CollectionInterface $orderList;
    protected CollectionInterface $paths;

    public function __construct(CollectionInterface $orderList, UserAccountPaths $paths)
    {
        $this->orderList = $orderList;
        $this->paths = $paths->Paths();
    }

    protected function orderDetailsInfos(object $order) : string
    {
        $html = '';
        $template = $this->getTemplate('itemInfosPath');
        $orderDetails = $this->orderList->offsetGet('order_details')->filter(function ($odr) use ($order) {
            return $odr->od_order_id === $order->ord_id;
        });
        if ($orderDetails->count() > 0) {
            foreach ($orderDetails as $od) {
                $temp = str_replace('{{ord_itemDescr}}', $od->short_descr, $template);
                $temp = str_replace('{{ord_itemtitle}}', $od->title, $temp);
                $temp = str_replace('{{ord_itemImg}}', $this->media($od), $temp);
                $html .= $temp;
            }
        }

        return $html;
    }
}
