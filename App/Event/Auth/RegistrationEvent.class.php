<?php

declare(strict_types=1);

class RegistrationEvent extends Event implements EmailSenderEventInterface
{
    public function __construct(object $object, ?string $eventName = null, array $params = [])
    {
        parent::__construct($object, $eventName == null ? $this::class : $eventName, $params);
    }

    /**
     * Get the value of emailConfig.
     */
    public function getEmailConfig() : EmailConfigurationEnv
    {
        list($emailconfig) = $this->getParams();
        return $emailconfig;
    }
}