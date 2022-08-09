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
        $this->updateAddress((array) $data, 'billing');
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Something goes wrong!')]);
    }

    public function autoFillInput(array $args = []) : void
    {
        /** @var AddressBookManager */
        $model = $this->model(AddressBookManager::class)->assign($this->isValidRequest());
        $model = $model->assign((array) $model->getDetails());
        /** @var CollectionInterface */
        $address = $model->getEntity()->getInitializedAttributes();
        if (!empty($address)) {
            $this->jsonResponse(['result' => 'success', 'msg' => $address]);
        }
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Something goes wrong!')]);
    }

    public function saveAddress(array $args = []) : void
    {
        /** @var AddressBookManager */
        $model = $this->model(AddressBookManager::class)->assign($data = $this->isValidRequest());
        $this->isIncommingDataValid(m: $model, ruleMethod:'address_book');
        $id = $model->getEntity()->{$model->getEntity()->getGetters($model->getEntity()->getColId())}();
        if ($resp = $model->save()) {
            /** @var CustomerEntity */
            $customerEntity = unserialize($this->session->get(CHECKOUT_PROCESS_NAME));
            $model = $model->assign((array) $model->getDetails($id)); //
            $address = (object) $model->getEntity()->getInitializedAttributes();

            $customerEntity->updateAddress($address);
            $this->session->set(CHECKOUT_PROCESS_NAME, serialize($customerEntity));
            list($html, $text) = $this->container(AddressBookPage::class)->delivery();
            $customerEntity->setShipTo($text);
            $this->session->set(CHECKOUT_PROCESS_NAME, serialize($customerEntity));
            $this->jsonResponse(['result' => 'success', 'msg' => [$data['addr'] => $html]]);
        }
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Something goes wrong!')]);
    }

    public function changeShipping(array $args = []) : void
    {
        $this->changeShippingClass();
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