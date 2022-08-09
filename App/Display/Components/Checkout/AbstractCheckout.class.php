<?php

declare(strict_types=1);

abstract class AbstractCheckout
{
    use DisplayTraits;
    use CheckoutTrait;
    use CheckoutFromTrait;
    protected ?CollectionInterface $userCart;
    protected ?CollectionInterface $shippingClass;
    protected ?CollectionInterface $paths;
    protected ?FormBuilder $frm;
    protected ?CollectionInterface $pmtMode;
    protected ?Customer $customer;
    protected ?ButtonsGroup $btns;
    protected ?CartSummary $cartSummary;
    protected ?ResponseHandler $response;
    protected ?AddressBookPage $addressBook;
    protected MoneyManager $money;
    protected ?CreditCardPage $creditCard;
    protected string $stripKey = STRIPE_KEY_PUBLIC;

    public function __construct(?CollectionInterface $userCart, ?CollectionInterface $shippingClass, ?CollectionInterface $pmtMode, ?FormBuilder $frm, ?CollectionInterface $paths, ?Customer $customer, ?CreditCardPage $creditCard = null)
    {
        $this->userCart = $userCart;
        $this->shippingClass = $shippingClass;
        $this->pmtMode = $pmtMode;
        $this->frm = $frm;
        $this->paths = $paths;
        $this->customer = $customer;
        $this->btns = new ButtonsGroup($this->frm);
        $this->addressBook = Container::getInstance()->make(AddressBookPage::class, [
            'customer' => $customer,
        ]);
        $this->money = MoneyManager::getInstance();
        $this->response = Container::getInstance()->make(ResponseHandler::class);
        $this->cartSummary = (new CartSummary($userCart, $this->shippingClass, $this->money, $this->paths));
        $this->creditCard = $creditCard;
    }

    protected function creditCardContent() : string
    {
        $template = $this->creditCard->creditCard(); //$this->getTemplate('creditCardTemplatePath');
        $template = str_replace('{{stripeKey}}', $this->stripKey, $template);
        $template = str_replace('{{cc_image}}', ImageManager::asset_img('visa.png'), $template);
        $template = str_replace('{{cardHolder}}', $this->frm->input([
            TextType::class => ['name' => 'card_holder', 'class' => ['card_holder']],
        ])->id('card_holder')->Label('Card Holder:')->placeholder(' ')->html(), $template);
        return $template;
    }

    protected function params() : array
    {
        return [
            'userCart' => $this->userCart,
            'shippingClass' => $this->shippingClass,
            'pmtMode' => $this->pmtMode,
            'frm' => $this->frm,
            'paths' => $this->paths,
            'customer' => $this->customer,
            'btns' => $this->btns,
            'summary' => $this->cartSummary,
            'addressBook' => $this->addressBook,
            'money' => $this->money,
            'response' => $this->response,
        ];
    }

    protected function addressBookContent() : string
    {
        list($htmlChk, $htmlModal, $text) = $this->addressBook->setCustomer($this->customer)->all();
        return $htmlModal;
    }

    protected function userCheckoutSesstion() : void
    {
        if (AuthManager::isUserLoggedIn()) {
            /** @var CustomerEntity */
            $en = $this->customer->getEntity();
            $session = Container::getInstance()->make(SessionInterface::class);
            if (!$session->exists(CHECKOUT_PROCESS_NAME)) {
                $en->setBillTo($this->getCustomerAddress($en, 'bill'));
                $en->setShipTo($this->getCustomerAddress($en, 'ship'));
                $en->setShippingMethod($this->shippingMethod($this->shippingClass));
                $en->setCartSummary($this->sessionCart($this->cartSummary));
                $en->setPromo('');
                $session->set(CHECKOUT_PROCESS_NAME, serialize($en));
            }
        }
    }

    private function getCustomerAddress(?CustomerEntity $en = null, ?string $type = null) : string
    {
        if (!is_null($en) && $en->isInitialized('address')) {
            /** @var CollectionInterface */
            $addresses = $en->{$en->getGetters('address')}();
            $customerAddress = $addresses->filter(function ($addr) use ($type) {
                if ($type != null) {
                    if ($type == 'ship') {
                        $addr->principale == 1 ? $addr->billing_addr = 'on' : '';
                        return $addr->principale == 1;
                    }
                    if ($type == 'bill') {
                        return $addr->billing_addr == 'on';
                    }
                } else {
                    throw new BaseException('Addresse type not spécified!');
                }
            });
            if ($customerAddress->count() === 1) {
                $get = $type == 'ship' ? 'delivery' : 'billing';
                list($htmlFrm, $htmlModal, $text) = $this->addressBook->$get();
                return $text;
            }
            if ($customerAddress->count() === 0 && $type == 'bill') {
                return $this->getCustomerAddress($en, 'ship');
            }
        }
        return '';
    }
}