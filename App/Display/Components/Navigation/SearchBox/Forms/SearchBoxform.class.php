<?php

declare(strict_types=1);
class SearchBoxForm extends ClientFormBuilder implements ClientFormBuilderInterface
{
    public function __construct(private FormBuilderBlueprint $frmPrint, ?Object $repository = null, ?string $templateName = null)
    {
        $path = APP . 'Display' . DS . 'Components' . DS . 'Navigation' . DS . 'SearchBox' . DS . 'Templates' . DS . lcfirst(($templateName ?? $this::class) . 'Template.php');
        if (file_exists($path)) {
            $this->template = file_get_contents($path);
        }
        parent::__construct($repository);
    }

    public function createForm(string $action, ?object $dataRepository = null, ?object $callingController = null) : mixed
    {
        $this->frm = $this->form([
            'action' => $action,
            'class' => ['search-bar'],
            'id' => 'search-box-frm',
        ]);
        $this->template = str_replace('{{form_begin}}', $this->frm->begin(), $this->template);

        $this->template = str_replace('{{input-search}}', (string) $this->frm->input([
            SearchType::class => ['name' => 'search', 'class' => ['search-bar__input'], 'id' => 'input-search'],
        ])->placeholder('type to search')->noLabel()->attr(['aria-label' => 'Search'])->html(), $this->template);

        $this->template = str_replace('{{button}}', (string) $this->frm->input([
            ButtonType::class => ['type' => 'submit', 'class' => ['search-bar__submit btn']],
        ])->noLabel()->content('<i class="fa-solid fa-magnifying-glass"></i>')->html(), $this->template);

        $this->template = str_replace('{{form_end}}', $this->frm->end(), $this->template);

        return $this->template;
    }
}