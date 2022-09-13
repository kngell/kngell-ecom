<?php

declare(strict_types=1);

trait CheckoutControllerTrait
{
    // protected function updateAddress(array $data = [], string $addrType = '') : void
    // {
    //     /** @var CustomerEntity */
    //     $customerEntity = unserialize($this->session->get(CHECKOUT_PROCESS_NAME));
    //     if ($customerEntity->isInitialized('address')) {
    //         $address = $customerEntity->getAddress()->filter(function ($addr) use ($data) {
    //             return $addr->ab_id === (int) $data['ab_id'];
    //         });
    //         $address = $address->pop();
    //         if ($addrType != '' && $addrType == 'shipping') {
    //             $address->principale = 'Y';
    //             $get = 'delivery';
    //         } elseif ($addrType != '' && $addrType == 'billing') {
    //             $address->billing_addr = 'Y';
    //             $get = 'billing';
    //         }
    //         $customerEntity->updateAddress($address);
    //         $this->session->set(CHECKOUT_PROCESS_NAME, serialize($customerEntity));
    //     }
    //     list($html_chk, $html, $text) = $this->container(AddressBookPage::class)->$get();
    //     $aryText = [];
    //     if (isset($data['addr'])) {
    //         $addr = json_decode($this->response->htmlDecode($data['addr']), true);
    //         if (is_array($addr)) {
    //             foreach ($addr as $selector) {
    //                 if ($selector == 'modal-address') {
    //                     $aryText[$selector] = $html;
    //                 } elseif ($selector == 'delivery-address-content') {
    //                     $aryText[$selector] = $html_chk;
    //                 } else {
    //                     $aryText[$selector] = $text;
    //                 }
    //             }
    //         } elseif (is_string($data['addr'])) {
    //             $aryText[$data['addr']] = $text;
    //         }
    //     }
    //     $this->jsonResponse(['result' => 'success', 'msg' => $aryText]);
    // }

    protected function changeShippingClass()
    {
        /** @var ShippingClassManager */
        $model = $this->model(ShippingClassManager::class)->assign($this->isValidRequest());
        $this->isIncommingDataValid(m: $model, ruleMethod:'shippingClass');
        $model = $model->assign((array) $model->getDetails());
        if ($model->count() === 1) {
            /** @var ShippingClassEntity */
            $shippingEntity = $model->getEntity();
            $shippingMethod = [
                'id' => 'sh_name' . $shippingEntity->getShcId(),
                'name' => (string) $shippingEntity->getShName(),
                'price' => MoneyManager::getInstance()->getFormatedAmount((string) $shippingEntity->getPrice()),
            ];
            /** @var CustomerEntity */
            $customerEntity = unserialize($this->session->get(CHECKOUT_PROCESS_NAME));

            $cartSummary = (new CartSummary($this->getUserCart(), $this->UserCheckoutShippingClass($model, (int) filter_var($shippingMethod['id'], FILTER_SANITIZE_NUMBER_INT)), MoneyManager::getInstance(), (new CheckoutPartials())->paths()));

            $customerEntity->setShippingMethod($shippingMethod);
            $cs = $customerEntity->getCartSummary();
            $cs->offsetSet('totalTTC', $cartSummary->getTTC());
            $customerEntity->setCartSummary($cs);
            $this->session->set(CHECKOUT_PROCESS_NAME, serialize($customerEntity));

            $this->jsonResponse(['result' => 'success', 'msg' => ['name' => $shippingMethod['name'], 'price' => $shippingMethod['price'], 'cart' => $cartSummary->total(), 'ttc' => $cartSummary->getTTC()->formatTo('fr_FR'), 'id' => $shippingMethod['id']]]);
        }
    }

    protected function getCustomerParams() : array
    {
        $gatewayMethod = 'createCustomer';
        $cust_id = '';
        if ($this->session->exists(CURRENT_USER_SESSION_NAME)) {
            $cust_id = $this->session->get(CURRENT_USER_SESSION_NAME)['customer_id'];
            if (!empty($cust_id) && $cust_id != '') {
                $gatewayMethod = 'retriveCustomer';
            }
        }

        return [$cust_id, $gatewayMethod];
    }
}
