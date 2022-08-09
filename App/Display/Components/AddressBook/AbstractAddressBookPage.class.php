<?php

declare(strict_types=1);

abstract class AbstractAddressBookPage
{
    use DisplayTraits;
    use AddressBookTraits;
    use AddressBookGetterAndSettersTrait;

    protected ?CollectionInterface $paths;
    protected ?Customer $customer;
    protected ?FormBuilder $frm;
    protected ?string $template;
    protected ?ResponseHandler $response;
    protected bool $noManageForm = false;
    private int $deliveryAddr = 1;
    private string $billingAddr = 'on';
    private SessionInterface $session;

    public function __construct(?AddressBookPath $paths = null, ?Customer $customer = null, ?FormBuilder $frm = null, ?ResponseHandler $response = null)
    {
        $this->session = Container::getInstance()->make(SessionInterface::class);
        $this->paths = $paths->Paths();
        $this->customer = $this->customer($customer);
        $this->frm = $frm;
        $this->template = $this->getTemplate('addressBookContentPath');
        $this->response = $response;
    }

    protected function addressBookContent(string $type = 'all') : array
    {
        return [$this->addressHtml('chk-frm'), $this->addressHtml(), $this->addressText($type)];
    }

    protected function addressText(string $type = 'all') : string
    {
        $text = '';
        /** @var CollectionInterface */
        $addresses = $this->addresses($type);
        if ($addresses->count() > 0) {
            foreach ($addresses as $address) {
                $text .= $this->singleAddressText($address);
            }
        }
        return $text;
    }

    protected function addresses(string $type = 'all') : CollectionInterface
    {
        /** @var CustomerEntity */
        $en = $this->customer->getEntity();
        if ($en->isInitialized('address')) {
            return match ($type) {
                'delivery' => $en->getAddress()->filter(function ($addr) {
                    return $addr->principale === $this->deliveryAddr;
                }),
                'billing' => $en->getAddress()->filter(function ($addr) {
                    return $addr->billing_addr === $this->billingAddr;
                }),
                default => $en->getAddress()
            };
        }
        return new Collection([]);
    }

    protected function addressBookHtml(string $htmlContent) : string
    {
        $template = $this->getTemplate('addressBookPath');
        $template = str_replace('{{content}}', $htmlContent, $template);
        return $template;
    }
}