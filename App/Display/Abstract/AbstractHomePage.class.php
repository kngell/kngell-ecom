<?php

declare(strict_types=1);

abstract class AbstractHomePage
{
    protected CollectionInterface $userCart;
    protected CheckoutForm $frm;

    public function __construct(CollectionInterface $userCart, CheckoutForm $frm)
    {
        $this->userCart = $userCart;
        $this->frm = $frm;
    }

    protected function outputUserInfosTemplate(string $template = '', string $dataTemplate = '') : string
    {
        if ($this->userCart->count() > 0) {
            $template = str_replace('{{userInfoAndData}}', $dataTemplate, $template);
            $template = str_replace('{{accountCheck}}', AuthManager::isUserLoggedIn() ? $this->accountCheckTemplate() : '', $template);
        }
        return $template;
    }

    private function accountCheckTemplate() : string
    {
        return '<div class="account-request">
                <span aria-hidden="true">Already have an account?</span>
                <a class="text-highlight" href="#" data-bs-toggle="modal"
                data-bs-target="#login-box">Login</a>
            </div>';
    }
}