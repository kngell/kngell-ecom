<?php

declare(strict_types=1);

class VisitorsController extends Controller
{
    public function track()
    {
        $data = $this->isValidRequest();
        if (!$this->cache->exists($this->cachedFiles['visitors'])) {
            /** @var VisitorsManager */
            $model = $this->model(VisitorsManager::class)->assign($data);
            $output = $model->manageVisitors($data);
            if ($output->count() > 0) {
                $this->cache->set($this->cachedFiles['visitors'], $output->getAllVisitors());
                $this->jsonResponse(['result' => 'success', 'msg' => true]);
            }
        }
        $resp = $this->isVisitorOk($this->cache->get($this->cachedFiles['visitors']), $data);
        if ((is_bool($resp) && $resp) || (is_object($resp) && $resp->count() > 0)) {
            $this->jsonResponse(['result' => 'success', 'msg' => $resp]);
        }
    }

    public function saveipdata()
    {
        if ($this->request->exists('post')) {
            $data = $this->response->transform_keys($this->request->get(), H_visitors::new_IpAPI_keys());
            $this->model_instance->assign($data);
            if (isset($data['ipAddress']) && !$this->model_instance->getByIp($data['ipAddress'])) {
                $this->model_instance->save();
            }
        }
    }

    private function isVisitorOk(?CollectionInterface $visitors, array $new_visitor) : VisitorsManager|bool
    {
        if ($visitors != null && $visitors->count() > 0) {
            foreach ($visitors as $visitor) {
                if ($visitor->ip_address == $new_visitor['ip']) {
                    if ($this->cookie->exists(VISITOR_COOKIE_NAME)) {
                        if ($visitor->cookies == $this->cookie->get(VISITOR_COOKIE_NAME)) {
                            return true;
                        }
                    }
                }
            }
            return $this->model(VisitorsManager::class)->assign($new_visitor)->manageVisitors($new_visitor);
        }
    }
}