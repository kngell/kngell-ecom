<?php

declare(strict_types=1);

class RegisterUserWithAjaxController extends Controller
{
    public function index(array $args = []) : void
    {
        /** @var RegisterUserManager */
        $model = $this->model(RegisterUserManager::class)->assign($this->isValidRequest());
        $this->isIncommingDataValid(m: $model, ruleMethod:'users', newKeys: [
            'email' => 'reg_email',
            'password' => 'reg_password',
        ]);
        $model = $this->uploadFiles($model);
        $model->setLastID($model->register()->count());
        $this->dispatcher->dispatch(new RegistrationEvent($model->getEntity(), null, $this->params()));
        $this->jsonResponse(['result' => 'success', 'msg' => $this->helper->showMessage('success', 'Bienvenu!<br>Vous pouvez vous connecter!')]);
    }

    private function params() : array
    {
        /** @var EmailConfigurationEnv */
        $emailConfig = $this->container(EmailConfigurationEnv::class);
        $emailConfig->setSubject('Email Vérification.');
        $emailConfig->setFrom('contact@kngell.com', 'K\'ngell Ingénierie Logistique');
        $emailConfig->setEmailClass(WelcomeEmail::class);

        return [$emailConfig];
    }
}
