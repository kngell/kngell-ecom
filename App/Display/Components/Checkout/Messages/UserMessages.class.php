<?php

declare(strict_types=1);

use Stripe\PaymentIntent;

class UserMessages
{
    use DisplayTraits;

    private PaymentIntent $paymentObject;
    private CollectionInterface $paths;
    private CustomerEntity $en;
    private string $success_massage = 'Merci pour votre achats';

    public function __construct(PaymentIntent $paymentObj, CustomerEntity $en, CheckoutPartials $paths)
    {
        $this->paymentObject = $paymentObj;
        $this->paths = $paths->Paths();
        $this->en = $en;
    }

    public function display()
    {
        $template = $this->getTemplate('succesMsgModalPath');
        $template = str_replace('{{status_message}}', $this->success_massage, $template);
        $template = str_replace('{{num_commande}}', $this->en->getOrderId(), $template);
        $template = str_replace('{{num_Transaction}}', $this->paymentObject->id, $template);
        $template = str_replace('{{TextMessage}}', $this->textMessage(), $template);
        return $template;
    }

    private function textMessage() : string
    {
        return 'Cher ' . $this->en->getFirstName() . ', merci pour votre achat.<br>Veuillez consulter votre Email tous les détails liés à votre commande.';
    }
}