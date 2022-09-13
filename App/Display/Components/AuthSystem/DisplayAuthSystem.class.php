<?php

declare(strict_types=1);

class DisplayAuthSystem extends AbstractAuthSystem implements DisplayPagesInterface
{
    public function __construct(FormBuilder $frm, AuthFilePath $paths)
    {
        parent::__construct($frm, $paths);
    }

    public function displayAll(): array
    {
        $authTemplate = $this->getTemplate('authTemplatePath');
        $authTemplate = str_replace('{{loginBox}}', $this->loginBox(), $authTemplate);
        $authTemplate = str_replace('{{registerBox}}', $this->registerBox(), $authTemplate);
        $authTemplate = str_replace('{{forgotBox}}', $this->forgotPwBox(), $authTemplate);

        return [
            'authenticationComponent' => $authTemplate,
        ];
    }

    private function loginBox() : string
    {
        $Box = $this->getTemplate('loginboxPath');

        return str_replace('{{loginForm}}', $this->loginForm(), $Box);
    }

    private function registerBox() : string
    {
        $Box = $this->getTemplate('registerboxPath');

        return str_replace('{{registerForm}}', $this->registerForm(), $Box);
    }

    private function forgotPwBox() : string
    {
        $Box = $this->getTemplate('forgotboxPath');

        return str_replace('{{forgotPassword}}', $this->forgotForm(), $Box);
    }

    private function verifyUserForm() : string
    {
        return '';
    }
}
