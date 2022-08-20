<?php

declare(strict_types=1);

class AddressBookPage extends AbstractAddressBookPage implements DisplayPagesInterface
{
    public function __construct(?AddressBookPath $paths = null, ?Customer $customer = null, ?FormBuilder $frm = null, ?ResponseHandler $response = null)
    {
        parent::__construct($paths, $customer, $frm, $response);
    }

    public function displayAll(): array
    {
        list($htmlchk, $html, $text) = $this->addressBookContent();
        return [
            'addressBook' => $this->addressBookHtml($html),
        ];
    }

    public function all(string $frmID = '') : array
    {
        list($hemltChk, $htmlModals, $text) = $this->addressBookContent('all', $frmID);
        return [
            $this->addressBookHtml($hemltChk),
            $this->addressBookHtml($htmlModals),
            $text,
        ];
    }

    public function delivery(string $frmID = '') : array
    {
        list($hemltChk, $htmlModals, $text) = $this->addressBookContent('delivery', $frmID);
        return [
            $this->addressBookHtml($hemltChk),
            $this->addressBookHtml($htmlModals),
            $text,
        ];
    }

    public function billing(string $frmID = '') : array
    {
        list($hemltChk, $htmlModals, $text) = $this->addressBookContent('billing', $frmID);
        return [
            $this->addressBookHtml($hemltChk),
            $this->addressBookHtml($htmlModals),
            $text,
        ];
    }

    public function deliveryAddrtext() : string
    {
        return $this->addressText('delivery');
    }

    public function billingAddrtext() : string
    {
        return $this->addressText('billing');
    }

    public function allAddrtext() : string
    {
        return $this->addressText();
    }
}