<?php

declare(strict_types=1);
class DisplayOrderResultListener implements ListenerInterface
{
    public function __construct(private ResponseHandler $response)
    {
    }

    public function handle(EventsInterface $event): iterable
    {
        /** @var PaymentGatewayInterface */
        $object = $event->getObject();
        $message = Container::getInstance()->make(UserMessages::class, [
            'paymentObj' => $object->getPaymentIntent(),
            'en' => $object->getCustomerEntity(),
        ])->display();
        $this->response->jsonResponse(['result' => 'success', 'msg' => $message]);
        return [];
    }
}