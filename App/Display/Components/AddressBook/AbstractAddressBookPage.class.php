<?php

declare(strict_types=1);

abstract class AbstractAddressBookPage
{
    use DisplayTraits;
    use AddressBookTraits;
    use AddressBookGetterAndSettersTrait;

    protected ?CollectionInterface $paths;
    protected ?CustomerEntity $customerEntity;
    protected ?FormBuilder $frm;
    protected ?string $template;
    protected ?ResponseHandler $response;
    protected bool $noManageForm = false;
    private string $deliveryAddr = 'Y';
    private string $billingAddr = 'Y';
    private SessionInterface $session;

    public function __construct(?AddressBookPath $paths = null, ?CustomerEntity $customerEntity = null, ?FormBuilder $frm = null, ?ResponseHandler $response = null)
    {
        $this->session = Container::getInstance()->make(SessionInterface::class);
        $this->paths = $paths->Paths();
        $this->customerEntity = $customerEntity;
        $this->frm = $frm;
        $this->template = $this->getTemplate('addressBookContentPath');
        $this->response = $response;
    }

    protected function addressBookContent(string $type = 'all', string $frmID = '') : array
    {
        return [$this->addressHtml('chk-frm', $frmID), $this->addressHtml(), $this->addressText($type)];
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
        if ($this->customerEntity->isInitialized('address')) {
            return match ($type) {
                'delivery' => $this->customerEntity->getAddress()->filter(function ($addr) {
                    return $addr->principale === $this->deliveryAddr;
                }),
                'billing' => $this->customerEntity->getAddress()->filter(function ($addr) {
                    return $addr->billing_addr === $this->billingAddr;
                }),
                default => $this->customerEntity->getAddress()
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
