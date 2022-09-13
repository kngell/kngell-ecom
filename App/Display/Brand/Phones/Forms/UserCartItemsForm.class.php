<?php

declare(strict_types=1);
class UserCartItemsForm extends ClientFormBuilder implements ClientFormBuilderInterface
{
    public function __construct(private FormBuilderBlueprint $frmPrint, ?Object $repository = null, ?string $templateName = null)
    {
        $path = APP . 'Display' . DS . 'Brand' . DS . 'Phones' . DS . 'Templates' . DS . lcfirst(($templateName ?? $this::class) . 'Template.php');
        if (file_exists($path)) {
            $this->template = file_get_contents($path);
        }
        parent::__construct($repository);
    }

    public function createForm(string $action, ?object $dataRepository = null, ?object $callingController = null) : mixed
    {
        $form = $this->form([
            'action' => $action,
            'class' => ['font-size-14', 'font-rale'],
            'id' => 'shopping-cart',
        ]);
        $dataRepository = $dataRepository->filter(function ($item) {
            return $item->cart_type === 'cart';
        });
        $this->template = str_replace('{{form_begin}}', $form->begin(), $this->template);
        $this->template = str_replace('{{route}}', '/cart', $this->template);
        $this->template = str_replace('{{NumberOfItems}}', (string) $dataRepository->count(), $this->template);
        $this->template = str_replace('{{form_end}}', $form->end(), $this->template);

        return $this->template;
    }
}
