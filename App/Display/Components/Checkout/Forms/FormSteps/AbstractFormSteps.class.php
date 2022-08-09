<?php

declare(strict_types=1);

use Brick\Money\Money;

abstract class AbstractFormSteps
{
    use DisplayTraits;
    use CheckoutTrait;
    use CheckoutFromTrait;
    use CheckoutGetterAndSetterTrait;

    protected MoneyManager $money;
    protected ResponseHandler $response;
    protected ?object $frm;
    protected ?ButtonsGroup $btns;
    protected ?CartSummary $summary;
    protected ?Customer $customer;
    protected ?CollectionInterface $paths;
    protected CollectionInterface $userCart;
    protected ?AddressBookPage $addressBook;
    protected Money $HT;
    protected Money $TTC;
    protected array $cartItems = [];
    protected CollectionInterface $finalTaxes;
    protected string $cardSubTotal = '';

    public function __construct()
    {
    }

    protected function customerAddress(int $addrType = 1, $addreMode = 'text') : string
    {
        if ($addrType == 1) {
            list($html, $text) = $this->addressBook->delivery();
        } elseif ($addrType == 2) {
            list($html, $text) = $this->addressBook->billing();
        } else {
            list($html, $text) = $this->addressBook->all();
        }
        return $addreMode == 'text' ? $this->response->htmlDecode($text) : $html;
    }

    protected function buttons(?string $nextText = null) : string
    {
        $btnGroup = $this->getTemplate('buttonGroupPath');
        $btnGroup = str_replace('{{buttonsLeft}}', $this->btns->buttonsGroup('prev'), $btnGroup);
        $btnGroup = str_replace('{{buttonsRight}}', $this->btns->buttonsGroup('next', $nextText), $btnGroup);
        return $btnGroup;
    }

    protected function titleTemplate(string $title = '') : string
    {
        return <<<HTML
            <div class="card-sub-title">
                <h4 class="title">
                $title
                </h4>
            </div>
    HTML;
    }

    protected function accountCheck() : string
    {
        return '<div class="account-request">
                <span aria-hidden="true">Connectez-vous pour continuer? <span class="text-danger">*</span> </span>
                <a class="text-highlight" href="#" data-bs-toggle="modal"
                data-bs-target="#login-box">Login</a>
            </div>';
    }
}