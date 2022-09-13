<?php

declare(strict_types=1);

abstract class AbstractUserAccount
{
    use DisplayTraits;

    protected CollectionInterface $paths;
    protected FormBuilder $frm;
    protected CustomReflector $reflect;
    protected ?ShowOrders $showOrders;
    protected ?Pagination $pagination;
    protected ?ShowProfile $profile;
    protected ?ShowAddress $showAddress;
    protected ?ShowUserCard $userCard;
    protected ?CustomerEntity $customerEntity;
    protected array $params;

    public function __construct(array $params)
    {
        $this->properties($params);
    }

    protected function user() : string
    {
        if ($this->customerEntity->isInitialized('user_id')) {
            return $this->frm->input([
                HiddenType::class => ['name' => 'user_id'],
            ])->value($this->customerEntity->getUserId())->noLabel()->noWrapper()->html();
        }
        return '';
    }

    protected function removeAccountButton() : string
    {
        if ($this->customerEntity->isInitialized('user_id')) {
            $this->frm->form([
                'action' => '#',
                'class' => ['remove-account-frm'],
            ])->setCsrfKey('remove-account-frm' . $this->customerEntity->getUserId());
            $buttonContent = '<span class="title"><i class="fa-solid fa-user-slash"></i></span>
                            <span>Remove account
                            </span>';
            $template = $this->getTemplate('removeAccountPath');
            $template = str_replace('{{form_begin}}', $this->frm->begin(), $template);
            $template = str_replace('{{button}}', $this->frm->input([
                ButtonType::class => ['type' => 'submit', 'class' => ['single-details-item__button"']],
            ])->content($buttonContent)->html(), $template);
            $template = str_replace('{{form_end}}', $this->frm->end(), $template);
            return $template;
        }
        return '';
    }

    protected function userform(string $templateName) : string
    {
        if (!$this->customerEntity->isInitialized('user_id')) {
            return '';
        }
        $this->frm->form([
            'action' => '#',
            'class' => ['user_form_' . $templateName],
        ])->setCsrfKey('user_form_' . $templateName);

        $template = $this->getTemplate('userFormPath');

        $template = str_replace('{{form_begin}}', $this->frm->begin(), $template);

        $template = str_replace('{{user_id}}', $this->frm->input([
            HiddenType::class => ['name' => 'ord_user_id'],
        ])->value($this->customerEntity->getUserId())->noLabel()->noWrapper()->html(), $template);

        $template = str_replace('{{template_name}}', $this->frm->input([
            HiddenType::class => ['name' => 'user_process'],
        ])->value($templateName)->noLabel()->noWrapper()->html(), $template);

        $template = str_replace('{{form_end}}', $this->frm->end(), $template);

        return $template;
    }
}