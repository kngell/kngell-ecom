<?php

declare(strict_types=1);

class CheckoutPaymentsController extends Controller
{
    use CheckoutControllerTrait;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function pay(array $args = []) : void
    {
        $payment = $this->container(PaymentServicesFactory::class, [
            'params' => array_merge($this->isValidRequest(), [
                'customerEntity' => $this->getCustomerEntityFromSession(),
            ]),
        ])->create();
        list($customer_id, $gatewayMethod) = $this->getCustomerParams();
        $payment = $payment->$gatewayMethod($customer_id)->createPayment()->confirmPayment();
        if (!$payment->ok()) {
            $this->jsonResponse(['result' => 'error', 'msg' => 'Something goes wrong']);
        }
        $this->dispatcher->dispatch(new PaymentEvent(object: $payment, name: '', params: [$this]));
    }
}
