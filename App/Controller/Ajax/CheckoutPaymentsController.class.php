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
            'params' => $this->isValidRequest(),
        ])->create()->customer()->createPayment()->confirmPayment();
        if ($payment->ok()) {
            $this->dispatcher->dispatch(new PaymentEvent(object: $payment));
            $this->jsonResponse(['result' => 'success', 'msg' => $payment]);
        }
        $this->jsonResponse(['result' => 'error', 'msg' => 'Something goes wrong']);
    }
}