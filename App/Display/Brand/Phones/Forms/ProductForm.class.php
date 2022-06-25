<?php

declare(strict_types=1);
class ProductForm extends ClientFormBuilder implements ClientFormBuilderInterface
{
    public function __construct(private FormBuilderBlueprint $frmPrint, ?Object $repository = null, ?string $templateName = null)
    {
        $path = APP . 'Display' . DS . 'Phones' . DS . 'Templates' . DS . lcfirst(($templateName ?? $this::class) . 'Template.php');
        if (file_exists($path)) {
            $this->template = file_get_contents($path);
        }
        parent::__construct($repository);
    }

    public function createForm(string $action, ?object $dataRepository = null, ?object $callingController = null) : mixed
    {
        $form = $this->form([
            'action' => $action,
            'class' => ['add_to_cart_frm'],
        ]);
        list($class, $title) = $this->producttitleAndClass($dataRepository);
        $template = $this->template;
        $this->setCsrfKey('add_to_cart_frm' . $dataRepository->pdt_id ?? 1);
        $template = str_replace('{{form_begin}}', $form->begin(), $template);
        $template = str_replace('{{item}}', (string) $form->input([
            HiddenType::class => ['name' => 'item_id'],
        ])->noLabel()->value($dataRepository->pdt_id), $template);
        $template = str_replace('{{user}}', (string) $form->input([
            HiddenType::class => ['name' => 'user_id'],
        ])->noLabel()->value('1'), $template);
        $template = str_replace('{{button}}', (string) $form->input([
            ButtonType::class => ['type' => 'submit', 'class' => $class],
        ])->content($title), $template);
        $template = str_replace('{{form_end}}', $form->end(), $template);
        return $template;
    }

    private function producttitleAndClass(?object $dataRepository = null) : array
    {
        /** @var CollectionInterface */
        $userCart = $dataRepository->userCart;
        $cartKeys = $userCart->map(function ($item) {
            if ($item->cart_type == 'cart') {
                return $item->item_id;
            }
        })->all();
        if (isset($cartKeys) && in_array($dataRepository->pdt_id, $cartKeys)) {
            return [['btn', 'btn-success', 'font-size-12'], 'In the Cart'];
        }
        return [['btn', 'btn-warning', 'font-size-12'], 'Add to Cart'];
    }
}