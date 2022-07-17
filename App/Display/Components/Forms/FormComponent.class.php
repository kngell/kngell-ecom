<?php

declare(strict_types=1);

class FormComponent extends ClientFormBuilder implements ClientFormBuilderInterface
{
    public function __construct(protected FormBuilderBlueprint $print, ?Object $repository = null, ?string $templateName = null)
    {
        $path = FILES . 'Template' . DS . 'Users' . DS . 'Auth' . DS . 'Forms' . DS . ($templateName ?? $this::class) . 'Template.php';
        if (file_exists($path)) {
            $this->template = file_get_contents($path);
        }
        parent::__construct($repository);
    }

    public function createForm(string $action, ?object $dataRepository = null, ?object $callingController = null) : mixed
    {
        $form = $this->form([
            'action' => $action,
            'id' => '',
            'class' => [],
            'enctype' => '',
        ]);
        return $form;
    }
}