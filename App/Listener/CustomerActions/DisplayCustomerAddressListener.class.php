<?php

declare(strict_types=1);
class DisplayCustomerAddressListener implements ListenerInterface
{
    public function handle(EventsInterface $event): iterable
    {
        /** @var CheckoutProcessChangeController */
        $controller = $event->getObject();
        /** @var CustomerEntity */
        $customerEntity = unserialize($controller->getSession()->get(CHECKOUT_PROCESS_NAME));
        $get = $this->getAddressBookMethod($event, $customerEntity);
        list($html_chk, $html, $text) = $controller->container(AddressBookPage::class)->$get('manage_frm');
        $messageToDisplay = $this->messageToDisplay($event, $html_chk, $html, $text, $get);
        $customerEntity->setShipTo($text);
        $controller->getSession()->set(CHECKOUT_PROCESS_NAME, serialize($customerEntity));
        $controller->jsonResponse(['result' => 'success', 'msg' => $messageToDisplay]);
        return [];
    }

    private function messageToDisplay(EventsInterface $event, ?string $html_chk = null, ?string $html = null, ?string $text = null, ?string $method = null) : array
    {
        $aryMessage = [];
        $data = $event->getParams()['data'];
        $object = $event->getObject();
        if (isset($data['addr'])) {
            $addr = json_decode($object->getResponse()->htmlDecode($data['addr']), true);
            if (is_array($addr)) {
                foreach ($addr as $key => $selector) {
                    if ($selector == 'modal-address') {
                        $aryMessage[$selector] = $html;
                    } elseif ($selector == 'delivery-address-content') {
                        $aryMessage[$selector] = $html_chk;
                    } else {
                        if ($method == 'delivery' && $selector == 'ship-to-address') {
                            $aryMessage[$selector] = $text;
                        } elseif ($method == 'billing' && $selector == 'bill-to-address') {
                            $aryMessage[$selector] = $text;
                        }
                    }
                }
            } elseif (is_string($data['addr'])) {
                $aryMessage[$data['addr']] = $text;
            }
        }
        return $aryMessage;
        // return match ($event->getName()) {
        //     'CustomerAddressChangeEent' => [$data['addr'] => $html],
        //     default => $this->defaultMessage($event, $html_chk, $html, $text)
        // };
    }

    private function defaultmessage(EventsInterface $event, ?string $html_chk = null, ?string $html = null, ?string $text = null) : array
    {
        $aryMessage = [];
        $object = $event->getObject();
        $data = $event->getParams()['data'];
        if (isset($data['addr'])) {
            $addr = json_decode($object->getResponse()->htmlDecode($data['addr']), true);
            if (is_array($addr)) {
                foreach ($addr as $key => $selector) {
                    if ($selector == 'modal-address') {
                        $aryMessage[$selector] = $html;
                    } elseif ($selector == 'delivery-address-content') {
                        $aryMessage[$selector] = $html_chk;
                    } elseif ($selector == '"bill-to-address') {
                        $aryMessage[$selector] = $text;
                    }
                }
            } elseif (is_string($data['addr'])) {
                $aryMessage[$data['addr']] = $text;
            }
        }
        return $aryMessage;
    }

    private function getAddressBookMethod(EventsInterface $event, CustomerEntity $customerEntity)
    {
        $addrType = $event->getParams()['data']['addrType'];
        if ($addrType != '' && $addrType == 'delivery') {
            $get = 'delivery';
        } elseif ($addrType != '' && $addrType == 'billing') {
            $get = 'billing';
        } else {
            $get = 'all';
        }
        return $get;
    }
}