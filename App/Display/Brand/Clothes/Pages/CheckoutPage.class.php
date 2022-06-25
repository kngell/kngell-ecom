<?php

declare(strict_types=1);

class CheckoutPage extends AbstractHomePage implements DisplayPagesInterface
{
    public function __construct(CollectionInterface|Closure $userCart, CheckoutForm $frm)
    {
        if ($userCart instanceof Closure) {
            $userCart = $userCart->__invoke();
        }
        parent::__construct($userCart, $frm);
    }

    public function displayAll(): array
    {
        return [
            'progressBar' => $this->progressBar(),
            'checkoutForm' => $this->frm->createForm('', $this->userCart),
        ];
    }

    private function progressBar() : string
    {
        $template = VIEW . 'client' . DS . 'components' . DS . 'checkout' . DS . 'partials' . DS . '_progress_bar.php';
        if (file_exists($template)) {
            return file_get_contents($template);
        }
        return '';
    }
}