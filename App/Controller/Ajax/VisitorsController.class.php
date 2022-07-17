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
                $this->cache->set($this->cachedFiles['visitors'], $output->count());
                $this->jsonResponse(['result' => 'success', 'msg' => true]);
            }
        }

        if ($resp = $this->cache->get($this->cachedFiles['visitors']) > 0) {
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
}