<?php

declare(strict_types=1);

class CreditCardPage extends AbstractCreditCardPage implements DisplayPagesInterface
{
    public function __construct(?CreditCardPaths $paths = null, ?Customer $customer = null, ?FormBuilder $frm = null, ?DateTimeManager $dm = null)
    {
        parent::__construct($paths, $customer, $frm, $dm);
    }

    public function displayAll(): array
    {
        return [
            'credit_card' => $this->creditCard(),
        ];
    }

    public function creditCard() : string
    {
        $template = $this->getTemplate('creditCardPath');
        // $template = str_replace('{{front}}', $this->getTemplate('ccFrontPath'), $template);
        // $template = str_replace('{{back}}', $this->getTemplate('ccBackPath'), $template);
        $template = str_replace('{{cc_form}}', $this->creditCardForm(), $template);

        return $template;
    }
}
