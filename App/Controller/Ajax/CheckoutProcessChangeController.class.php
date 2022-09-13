<?php

declare(strict_types=1);

class CheckoutProcessChangeController extends Controller
{
    use CheckoutControllerTrait;

    public function __construct(array $params = [])
    {
        parent::__construct($params);
    }

    public function changeEmail(array $args = []) : void
    {
        /** @var UsersManager */
        $model = $this->model(UsersManager::class)->assign($this->isValidRequest());
        $this->isIncommingDataValid(m: $model, ruleMethod:'email', newKeys:[
            'email' => 'chg-email',
        ]);
        /** @var UsersEntity */
        $en = $model->getEntity();
        if ($en->isInitialized('email')) {
            /** @var CustomerEntity */
            $customerEntity = unserialize($this->session->get(CHECKOUT_PROCESS_NAME));
            $customerEntity->setEmail($en->getEmail());
            $this->session->set(CHECKOUT_PROCESS_NAME, serialize($customerEntity));
            $this->jsonResponse(['result' => 'success', 'msg' => $en->getEmail()]);
        }
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Something goes wrong!')]);
    }

    public function getAddress(array $args = []) : void
    {
        $data = $this->isValidRequest();
        $this->dispatcher->dispatch(new CheckoutNavigationEvent(object: $this, name: '', params: [
            'data' => $data,
        ]));
        $this->updateAddress((array) $data, 'billing');
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Something goes wrong!')]);
    }

    public function autoFillInput(array $args = []) : void
    {
        $data = $this->isValidRequest();
        /** @var CustomerEntity */
        $customerEntity = unserialize($this->session->get(CHECKOUT_PROCESS_NAME));
        /** @var CollectionInterface */
        $address = $customerEntity->getAddress()->filter(function ($addr) use ($data) {
            return $addr->ab_id == $data['ab_id'];
        });
        if ($address->count() === 1) {
            $address = $this->response->htmlDecodeArray((array) $address->pop());
            $this->jsonResponse(['result' => 'success', 'msg' => $address]);
        }
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Something goes wrong!')]);
    }

    public function saveAddress(array $args = []) : void
    {
        /** @var AddressBookManager */
        $model = $this->model(AddressBookManager::class)->assign($data = $this->isValidRequest());
        $this->isIncommingDataValid(m: $model, ruleMethod:'address_book');
        if ($resp = $model->saveAddress('users', $this->session->get(CURRENT_USER_SESSION_NAME)['id'])) {
            $this->dispatcher->dispatch(new CustomerAddressChangeEvent(object: $this, name: '', params: [
                'addressBookManager' => $model,
                'data' => $data,
            ]));
        }
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Something goes wrong!')]);
    }

    public function delete(array $args = []) : void
    {
        /** @var AddressBookManager */
        $model = $this->model(AddressBookManager::class)->assign($data = $this->isValidRequest());
        if ($resp = $model->delete()) {
            $this->dispatcher->dispatch(new CustomerAddressDeleteEvent(object: $this, name: '', params: [
                'addressBookManager' => $model,
                'data' => $data,
            ]));
        }
    }

    public function changeShipping(array $args = []) : void
    {
        $this->changeShippingClass();
    }

    private function addressType(AddressBookManager $m) : string
    {
        /** @var AddressBookEntity */
        $en = $m->getEntity();
        if ($en->getPrincipale() == 'Y') {
            return 'shipping';
        }
        if ($en->getBillingAddr() == 'Y') {
            return 'billing';
        }

        return 'all';
    }

    private function getAddressmethod(array $args, object $address) : array
    {
        if (current($args) == 'ship-to-address') {
            $update = 'setShipTo';
            $get = 'delivery';
            $address->principale = 1;
        } elseif (current($args) == 'bill-to-address') {
            $update = 'setBillTo';
            $get = 'billing';
            $address->billing_addr = 'on';
        } else {
            $update = '';
            $get = 'all';
            $address->principale = 0;
        }

        return [$update, $get, $address];
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
}
