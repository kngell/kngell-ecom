<?php

declare(strict_types=1);
class ClearCustomerCacheListener implements ListenerInterface
{
    public function __construct(private CacheInterface $cache, private SessionInterface $session)
    {
    }

    public function handle(EventsInterface $event): iterable
    {
        /** @var PaymentGatewayInterface */
        $object = $event->getParams()[0];
        if ($this->session->exists(CURRENT_USER_SESSION_NAME)) {
            $file = 'customer' . $this->session->get(CURRENT_USER_SESSION_NAME)['id'];
            if ($this->cache->exists($file)) {
                $this->cache->delete($file);
            }
        }

        return [];
    }
}
