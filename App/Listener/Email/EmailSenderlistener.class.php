<?php

declare(strict_types=1);

class EmailSenderlistener extends AbstractEmailSenderListener implements ListenerInterface
{
    private MailerFacade $mailerFacade;

    public function __construct()
    {
    }

    public function handle(Object $event) : iterable
    {
        /** @var EmailConfigurationEnv */
        $emailConfig = $event->getEmailConfig();

        /** @var Entity */
        $object = $event->getObject();

        /** @var string */
        $emailHtml = Container::getInstance()->make($emailConfig->getEmailClass(), [
            'en' => $object,
        ])->displayAll();

        $this->mailerFacade = Container::getInstance()->make(MailerFacade::class, [
            'settings' => $emailConfig->getSettings(),
        ]);

        $mail = $this->mailerFacade->charset('utf-8')
            ->basicMail($emailConfig->getSubject(), $emailConfig->getFrom(), $object->{$object->getGetters('email')}(), $emailHtml);

        return [$mail];
    }
}
