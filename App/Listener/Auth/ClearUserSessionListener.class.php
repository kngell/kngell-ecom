<?php

declare(strict_types=1);

class ClearUserSessionListener implements ListenerInterface
{
    public function __construct(private ResponseHandler $response, private RequestHandler $request, private RooterInterface $rooter)
    {
    }

    /**
     * @param EventsInterface $event
     */
    public function handle(EventsInterface $event): iterable
    {
        /** @var UserSessionsManager */
        $object = $event->getObject();
        $delete = null;
        if (!$object->getEntity()->isInitialized('remember_me_cookie')) {
            $object->getQueryParams()->reset();
            $delete = $object->delete();
        }
        // if ($this->request->isAjax()) {
        //     echo "<script>document.location.href='" . 'restricted' . DS . 'index' . "'</script>";
        // } else {
        //     $url = HOST . DS . 'home';
        //     $this->response->redirect($url);
        // }
        return [$delete];
    }
}
