<?php

declare(strict_types=1);

class CheckoutPage extends AbstractHomePage implements DisplayPagesInterface
{
    public function __construct(CollectionInterface|Closure $userCart, CollectionInterface|Closure $shippingClass, CheckoutForm $frm)
    {
        if ($userCart instanceof Closure) {
            $userCart = $userCart->__invoke();
        }
        if ($shippingClass instanceof Closure) {
            $shippingClass = $shippingClass->__invoke();
        }
        parent::__construct($userCart, $shippingClass, $frm, (new CheckoutPartials())->paths());
    }

    public function displayAll(): array
    {
        $this->userCart->offsetSet('paths', $this->paths);
        $this->userCart->offsetSet('shipping', $this->shippingClass);
        return [
            'progressBar' => $this->progressBar(),
            'checkoutForm' => $this->frm->createForm('', $this->userCart),
        ];
    }

    private function progressBar() : string
    {
        $template = $this->paths->offsetGet('progressBarPath');
        if (file_exists($template)) {
            return file_get_contents($template);
        }
        return '';
    }
}