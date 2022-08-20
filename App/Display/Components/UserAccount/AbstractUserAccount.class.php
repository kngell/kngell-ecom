<?php

declare(strict_types=1);

abstract class AbstractUserAccount
{
    use DisplayTraits;

    protected CollectionInterface $paths;
    protected FormBuilder $frm;
    protected UsersEntity $en;
    protected CollectionInterface $orderList;

    public function __construct(CollectionInterface $orderList, FormBuilder $frm, UserAccountPaths $paths)
    {
        $this->paths = $paths->Paths();
        $this->frm = $frm;
        if (AuthManager::isUserLoggedIn()) {
            $this->en = AuthManager::currentUser()->getEntity();
        } else {
            throw new BaseException('You do not have permissions to access this page. Please Log In!', 1);
        }
        $this->orderList = $orderList;
    }

    protected function showOrderList() : string
    {
        return Container::getInstance()->make(ShowOrders::class, ['orderList' => $this->orderList])->displayAll();
    }

    protected function pagination() : string
    {
        return Container::getInstance()->make(Pagination::class, [
            'params' => $this->orderList->offsetGet('params'),
        ])->displayAll();
    }

    protected function user() : string
    {
        return $this->frm->input([
            HiddenType::class => ['name' => 'user_id'],
        ])->value($this->en->getUserId())->noLabel()->noWrapper()->html();
    }

    protected function removeAccountButton() : string
    {
        $this->frm->form([
            'action' => '#',
            'class' => ['remove-account-frm'],
        ])->setCsrfKey('remove-account-frm' . $this->en->getUserId());
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

    protected function userform(string $templateName) : string
    {
        $this->frm->form([
            'action' => '#',
            'class' => ['user_form_' . $templateName],
        ])->setCsrfKey('user_form_' . $templateName);

        $template = $this->getTemplate('userFormPath');

        $template = str_replace('{{form_begin}}', $this->frm->begin(), $template);

        $template = str_replace('{{user_id}}', $this->frm->input([
            HiddenType::class => ['name' => 'ord_user_id'],
        ])->value($this->en->getUserId())->noLabel()->noWrapper()->html(), $template);

        $template = str_replace('{{template_name}}', $this->frm->input([
            HiddenType::class => ['name' => 'user_process'],
        ])->value($templateName)->noLabel()->noWrapper()->html(), $template);

        $template = str_replace('{{form_end}}', $this->frm->end(), $template);
        return $template;
    }
}