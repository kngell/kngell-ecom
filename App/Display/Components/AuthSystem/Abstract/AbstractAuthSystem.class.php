<?php

declare(strict_types=1);

abstract class AbstractAuthSystem
{
    protected FormComponent $frm;
    protected CollectionInterface $paths;
    protected string $authTemplate;
    protected string $loginLabel = '<div>&nbspRemember Me&nbsp</div>';
    protected string $registerLabel = '<div>J\'accepte&nbsp;<a href="#">les termes&nbsp;</a>&amp;&nbsp;<a href="#">conditions</a> d\'utilisation</div>';

    public function __construct(FormComponent $frm, AuthFilePath $paths)
    {
        $this->frm = $frm;
        $this->paths = $paths->Paths();
        $this->isFileExist($this->paths->offsetGet('authTemplatePath'));
        $this->authTemplate = file_get_contents($this->paths->offsetGet('authTemplatePath'));
        $this->frm->globalClasses([
            'wrapper' => [],
            'input' => ['input-box__input'],
            'label' => ['input-box__label'],
        ]);
    }

    protected function isFileExist(string $path) : bool
    {
        if (!file_exists($path)) {
            throw new BaseException('Chemin du fichier non valide');
        }
        return true;
    }

    protected function loginForm() : string
    {
        if (!file_exists($this->paths->offsetGet('loginTemplatePath'))) {
            throw new BaseException('No file exist on this location');
        }
        $loginTemplate = file_get_contents($this->paths->offsetGet('loginTemplatePath'));
        $form = $this->frm->setTemplate($loginTemplate);
        $print = $form->getPrint();
        $form->form([
            'action' => '',
            'id' => 'login-frm',
            'class' => ['login-frm'],
            'enctype' => 'multipart/form-data',
        ]);
        $loginTemplate = str_replace('{{form_begin}}', $form->begin(), $loginTemplate);
        $loginTemplate = str_replace('{{email}}', $form->input($print->email(name:'email'))
            ->placeholder('Email :')
            ->class(['email'])
            ->id('email')
            ->noLabel()
            ->html(), $loginTemplate);
        $loginTemplate = str_replace('{{password}}', $form->input($print->password(name:'password'))
            ->placeholder('Password :')
            ->id('password')
            ->noLabel()
            ->html(), $loginTemplate);
        $loginTemplate = str_replace('{{remamber_me}}', $form->input($print->checkbox(name:'remember_me'))
            ->labelClass(['checkbox'])
            ->label($this->loginLabel)
            ->spanClass(['checkbox__box text-danger'])
            ->id('remember_me')
            ->html(), $loginTemplate);
        $loginTemplate = str_replace('{{submit}}', $form->input($print->submit(name: 'sigin'))
            ->label('Login')->id('sigin')
            ->html(), $loginTemplate);
        $loginTemplate = str_replace('{{form_end}}', $form->end(), $loginTemplate);
        return $loginTemplate;
    }

    protected function registerForm() : string
    {
        $registerTemplate = file_get_contents($this->paths->offsetGet('registerTemplatePath'));
        $form = $this->frm->setTemplate($registerTemplate);
        $form->form([
            'id' => 'register-frm',
            'class' => ['register-frm'],
            'enctype' => 'multipart/form-data',
        ]);
        $registerTemplate = str_replace('{{form_begin}}', $form->begin(), $registerTemplate);
        $registerTemplate = str_replace('{{camera}}', ImageManager::asset_img('camera' . DS . 'camera-solid.svg'), $registerTemplate);
        $registerTemplate = str_replace('{{avatar}}', ImageManager::asset_img('users' . DS . 'avatar.png'), $registerTemplate);
        $registerTemplate = str_replace('{{last_name}}', (string) $form->input([
            TextType::class => ['name' => 'lastName'],
        ])->placeholder('First Name :')->noLabel(), $registerTemplate);
        $registerTemplate = str_replace('{{first_name}}', (string) $form->input([
            TextType::class => ['name' => 'firstName'],
        ])->placeholder('First Name :')->noLabel(), $registerTemplate);
        $registerTemplate = str_replace('{{username}}', (string) $form->input([
            TextType::class => ['name' => 'userName'],
        ])->placeholder('UserName')->noLabel(), $registerTemplate);
        $registerTemplate = str_replace('{{email}}', (string) $form->input([
            EmailType::class => ['name' => 'email', 'id' => 'reg_email'],
        ])->placeholder('Email :')->noLabel(), $registerTemplate);
        $registerTemplate = str_replace('{{password}}', (string) $form->input([
            PasswordType::class => ['name' => 'password', 'id' => 'reg_password'],
        ])->placeholder('Password :')->noLabel(), $registerTemplate);
        $registerTemplate = str_replace('{{cpassword}}', (string) $form->input([
            PasswordType::class => ['name' => 'cpassword'],
        ])->placeholder('Confirm Password :')->noLabel(), $registerTemplate);
        $registerTemplate = str_replace('{{terms}}', (string) $form->input([
            CheckboxType::class => ['name' => 'terms', 'id' => 'terms'],
        ])->label($this->registerLabel)->labelClass(['checkbox'])->spanClass(['checkbox__box text-danger'])->req(), $registerTemplate);
        $registerTemplate = str_replace('{{submit}}', (string) $form->input([
            SubmitType::class => ['name' => 'reg_singin'], ], null, ['show_label' => false,
            ])->label('Register')->id('reg_singin'), $registerTemplate);
        $registerTemplate = str_replace('{{form_end}}', $form->end(), $registerTemplate);
        return $registerTemplate;
    }

    protected function forgotForm() : string
    {
        $template = file_get_contents($this->paths->offsetGet('forgotPwTemplatePath'));
        $form = $this->frm->setTemplate($template);
        $form->form([
            'action' => '',
            'id' => 'forgot-frm',
            'class' => ['forgot-frm'],
            'enctype' => 'multipart/form-data',
        ]);
        $template = str_replace('{{form_begin}}', $form->begin(), $template);
        $template = str_replace('{{email}}', (string) $form->input([
            EmailType::class => ['name' => 'email', 'id' => 'forgot_email'],
        ])->placeholder('Email :')->class(['email'])->noLabel(), $template);
        $template = str_replace('{{submit}}', (string) $form->input([
            SubmitType::class => ['name' => 'forgot'],
        ])->label('Reset Password'), $template);
        $template = str_replace('{{form_end}}', $form->end(), $template);
        return $template;
    }
}