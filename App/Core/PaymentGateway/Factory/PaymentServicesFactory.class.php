<?php

declare(strict_types=1);

class PaymentServicesFactory
{
    private string $defaultPlatForm = 'stripe';
    private ?string $plateForm = null;
    private ContainerInterface $container;
    private string $gatewaySuffix = 'GatewayService';
    private ?CollectionInterface $paymentMethod = null;
    private ResponseHandler $response;

    public function __construct(array $params, ResponseHandler $response)
    {
        $this->response = $response;
        $this->properties($params);
    }

    public function create() : PaymentGatewayInterface
    {
        if (null === $this->plateForm) {
            $gateway = ucfirst($this->defaultPlatForm) . $this->gatewaySuffix;
            $gatewayObject = $this->container->make($gateway, ['paymentMethod' => $this->paymentMethod]);
            if (!$gatewayObject instanceof PaymentGatewayInterface) {
                throw new PaymentGatewayException("$gateway is not a valid instance of Payment!");
            }
            return $gatewayObject;
        }
        return $this->paymentPlateForm();
    }

    private function paymentPlateForm() : PaymentGatewayInterface
    {
        $pfInt = (int) filter_var($this->plateForm, FILTER_SANITIZE_NUMBER_INT);
        $this->plateForm = null;
        $gatewayString = match ($pfInt) {
            1 => $this->defaultPlatForm = 'stripe',
            2 => $this->defaultPlatForm = 'paypal',
            3 => $this->defaultPlatForm = 'amazon',
            4 => $this->defaultPlatForm = 'klarna',
            default => throw new PaymentGatewayException('Unknown payment Services!'),
        };
        return $this->create();
    }

    private function properties(array $params) : void
    {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $key = Stringify::camelCase($key);
                if ($key === 'paymentMethod') {
                    $value = new Collection(json_decode($this->response->htmlDecode($value), true)['paymentMethod']);
                }
                if (property_exists($this, $key)) {
                    !empty($value) ? $this->{$key} = $value : '';
                }
            }
        }
    }
}