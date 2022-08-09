<?php

declare(strict_types=1);
class ClearLoginAttempsListener implements ListenerInterface
{
    public function handle(EventsInterface $event): iterable
    {
        /** @var UserSessionsManager */
        $object = $event->getObject();
        if ($object instanceof UserSessionsEntity) {
            /** @var LoginAttemptsManager */
            $loginAttemps = Container::getInstance()->make(LoginAttemptsManager::class);
            $conditions = $loginAttemps->table()->where(['user_id' => $object->getUserId()])->build();
            $delete = $loginAttemps->delete($conditions);
            return [$delete];
        }
        return [];
    }
}