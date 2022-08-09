<?php

declare(strict_types=1);

abstract class AbstractAuthSystem
{
    use DisplayTraits;

    protected FormBuilder $frm;
    protected CollectionInterface $paths;
    protected string $authTemplate;
    protected string $loginLabel = '<div>&nbspRemember Me&nbsp</div>';
    protected string $registerLabel = '<div>J\'accepte&nbsp;<a href="#">les termes&nbsp;</a>&amp;&nbsp;<a href="#">conditions</a> d\'utilisation</div>';

    public function __construct(FormBuilder $frm, AuthFilePath $paths)
    {
        $this->frm = $frm;
        $this->paths = $paths->Paths();
        $this->getTemplate('authTemplatePath');
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
        $loginTemplate = $this->getTemplate('loginTemplatePath');
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
            ->placeholder(' ')
            ->class(['email'])
            ->id('email')
            ->label('Email :')
            ->html(), $loginTemplate);
        $loginTemplate = str_replace('{{password}}', $form->input($print->password(name:'password'))
            ->placeholder(' ')
            ->id('password')
            ->Label('Password :')
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
        $registerTemplate = $this->getTemplate('registerTemplatePath');
        $form = $this->frm->setTemplate($registerTemplate);
        $form->form([
            'id' => 'register-frm',
            'class' => ['register-frm'],
            'enctype' => 'multipart/form-data',
        ]);
        $registerTemplate = str_replace('{{form_begin}}', $form->begin(), $registerTemplate);
        $registerTemplate = str_replace('{{camera}}', ImageManager::asset_img('camera' . DS . 'camera-solid.svg'), $registerTemplate);
        $registerTemplate = str_replace('{{avatar}}', ImageManager::asset_img('users' . DS . 'avatar.png'), $registerTemplate);
        $registerTemplate = str_replace('{{last_name}}', $form->input([
            TextType::class => ['name' => 'lastName'],
        ])->placeholder(' ')->label('Last Name :')->id('lastName')->html(), $registerTemplate);
        $registerTemplate = str_replace('{{first_name}}', $form->input([
            TextType::class => ['name' => 'firstName'],
        ])->placeholder(' ')->label('First Name :')->id('firstName')->html(), $registerTemplate);
        $registerTemplate = str_replace('{{username}}', $form->input([
            TextType::class => ['name' => 'userName'],
        ])->placeholder(' ')->label('UserName')->id('username')->html(), $registerTemplate);
        $registerTemplate = str_replace('{{email}}', $form->input([
            EmailType::class => ['name' => 'email', 'id' => 'reg_email'],
        ])->placeholder(' ')->label('Email :')->html(), $registerTemplate);
        $registerTemplate = str_replace('{{password}}', $form->input([
            PasswordType::class => ['name' => 'password', 'id' => 'reg_password'],
        ])->placeholder(' ')->label('Password :')->html(), $registerTemplate);
        $registerTemplate = str_replace('{{cpassword}}', $form->input([
            PasswordType::class => ['name' => 'cpassword'],
        ])->placeholder(' ')->label('Confirm Password :')->id('cpassword')->html(), $registerTemplate);
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
        $template = $this->getTemplate('forgotPwTemplatePath');
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