<?php

declare(strict_types=1);

class CheckoutNavigationController extends Controller
{
    use CheckoutControllerTrait;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function validate(array $args = []) : void
    {
        $data = $this->isValidRequest();
        if ($data == false) {
            $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Invalid csrf Token! Please connect login In to continue.')]);
        }
        if ($data && isset($data['page'])) {
            $resp = match ($data['page']) {
                '0' => $this->validateInfosContact($data),
                '1' => $this->validateShippingClass($data),
                '2' => $this->validateBillingAddress($data),
                '3' => $this->jsonResponse(['result' => 'success', 'msg' => 'success'])
            };
        }
    }

    private function validateShippingClass(array $data = [])
    {
        $this->changeShippingClass();
    }

    private function UserCheckoutShippingClass(?ShippingClassManager $model = null, ?int $shID = null) : CollectionInterface
    {
        $shAry = [];
        /** @var CollectionInterface */
        $shs = $this->getShippingClass($model);
        foreach ($shs as $shClass) {
            $shClass->default_shipping_class = '0';
            if ($shClass->shc_id == $shID) {
                $shClass->default_shipping_class = '1';
            }
            $shAry[] = $shClass;
        }

        return new collection($shAry);
    }

    private function validateInfosContact(array $data = [])
    {
        if (AuthManager::isUserLoggedIn()) {
            /** @var UsersManager */
            $model = $this->model(UsersManager::class)->assign($data);
            $this->isIncommingDataValid(m: $model, ruleMethod:'contact_infos', newKeys: [
                'email' => 'chk-email',
                'firstName' => 'chk-firstName',
                'lastName' => 'chk-lastName',
            ]);
            $this->dispatcher->dispatch(new CheckoutNavigationEvent(object: $this, name: '', params: [
                'data' => $data,
                'addrType' => 'shipping',
            ]));
        }
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Veuillez créer un compte ou vous connecter pour continuer!')]);
    }

    private function validateBillingAddress(array $data = [])
    {
        if ($data['ab_id'] != 'undefined') {
            $this->dispatcher->dispatch(new CheckoutNavigationEvent(object: $this, name: '', params: [
                'data' => $data,
                'addrType' => 'billing',
            ]));
        }
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Something goes wrong!')]);
    }
}
