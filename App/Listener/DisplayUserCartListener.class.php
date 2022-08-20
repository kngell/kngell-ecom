<?php

declare(strict_types=1);
class DisplayUserCartListener implements ListenerInterface
{
    public function handle(EventsInterface $event): iterable
    {
        /** @var UserCartController */
        $object = $event->getObject();
        $params = $event->getParams();
        $object->getResponse()->jsonResponse([
            'result' => 'success',
            'msg' => $this->msgToDisplay($params, $object),
            'url' => $object->isInitialized('url') ? $object->getUrl() : null,
        ]);
        return [];
    }

    private function msgToDisplay(array $params, UserCartController $object) : array
    {
        $msg = [];
        foreach ($params as $method) {
            $elem = $object->$method();
            foreach ($elem as $key => $value) {
                $msg[$key] = $value;
            }
        }
        return $msg;
    }
}