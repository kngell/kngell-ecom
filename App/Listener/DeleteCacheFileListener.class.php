<?php

declare(strict_types=1);
class DeleteCacheFileListener implements ListenerInterface
{
    public function handle(EventsInterface $event): iterable
    {
        /** @var UserCartController */
        $object = $event->getObject();
        if ($object->getCache()->exists($object->getCachedFiles()['user_cart'])) {
            $object->getCache()->delete($object->getCachedFiles()['user_cart']);
        }
        return [];
    }
}