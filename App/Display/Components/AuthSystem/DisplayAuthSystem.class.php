<?php

declare(strict_types=1);

class DisplayAuthSystem extends AbstractAuthSystem implements DisplayPagesInterface
{
    public function __construct(FormComponent $frm, AuthFilePath $paths)
    {
        parent::__construct($frm, $paths);
    }

    public function displayAll(): array
    {
        $authTemplate = $this->paths->offsetGet('authTemplatePath');
        $this->isFileExist($authTemplate);
        $authTemplate = file_get_contents($authTemplate);
        $authTemplate = str_replace('{{loginBox}}', $this->loginBox(), $authTemplate);
        $authTemplate = str_replace('{{registerBox}}', $this->registerBox(), $authTemplate);
        $authTemplate = str_replace('{{forgotBox}}', $this->forgotPwBox(), $authTemplate);
        return [
            'authenticationComponent' => $authTemplate,
        ];
    }

    private function loginBox() : string
    {
        $this->isFileExist($this->paths->offsetGet('loginboxPath'));
        $Box = file_get_contents($this->paths->offsetGet('loginboxPath'));
        return str_replace('{{loginForm}}', $this->loginForm(), $Box);
    }

    private function registerBox() : string
    {
        $Box = $this->paths->offsetGet('registerboxPath');
        $this->isFileExist($Box);
        $Box = file_get_contents($Box);
        return str_replace('{{registerForm}}', $this->registerForm(), $Box);
    }

    private function forgotPwBox() : string
    {
        $Box = $this->paths->offsetGet('forgotboxPath');
        $this->isFileExist($Box);
        $Box = file_get_contents($Box);
        return str_replace('{{forgotPassword}}', $this->forgotForm(), $Box);
    }

    private function verifyUserForm() : string
    {
        return '';
    }
}