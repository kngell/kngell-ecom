<?php

declare(strict_types=1);

trait ControllerTrait
{
    /**
     * Set the value of commentOutput.
     *
     * @return  self
     */
    public function setCommentsArg(mixed $commentOutput) : self
    {
        $this->customProperties['comments'] = $commentOutput;
        return $this;
    }

    public function frontComponents(array $froncComponents = []) : self
    {
        $this->frontEndComponents = $froncComponents;
        return $this;
    }

    /**
     * Get the value of commentOutput.
     */
    public function outputComments() : array
    {
        return array_filter($this->customProperties, function ($prop) {
            return in_array($prop, ['comments']);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function getSettings() : object
    {
        if (!$this->cache->exists('settings')) {
            $this->cache->set('settings', $this->container(SettingsManager::class)->getSettings());
        }
        return $this->cache->get('settings');
    }

    public function container(?string $class = null, array $args = []) : object
    {
        if (null != $class) {
            return Application::diGet($class, $args);
        }
        return Application::getInstance();
    }

    public function displayUserCart() : array
    {
        return  $this->container(DisplayUserCart::class, [
            'userCart' => function () {
                if (!$this->cache->exists($this->cachedFiles['user_cart'])) {
                    $this->cache->set($this->cachedFiles['user_cart'], $this->model(CartManager::class)->getUserCart());
                }
                return $this->cache->get($this->cachedFiles['user_cart']);
            },
        ])->displayAll();
    }

    protected function isIncommingDataValid(Model $m, string $ruleMethod, array $newKeys = []) : void
    {
        method_exists('Form_rules', $ruleMethod) ? $m->validator(Form_rules::$ruleMethod()) : '';
        if (!$m->validationPasses()) {
            $this->jsonResponse(['result' => 'error-field', 'msg' => $m->getErrorMessages($newKeys)]);
        }
    }

    protected function uploadFiles(Model $m) : Object
    {
        list($uploaders, $paths) = $this->container(UploaderFactory::class, [
            'filesAry' => $this->request->getFiles(),
        ])->create($m);
        if (is_array($uploaders) && !empty($uploaders)) {
            foreach ($uploaders as $uploader) {
                $paths[] = $uploader->upload($m);
            }
        }
        $m->getEntity()->{'set' . ucfirst($m->getEntity()->getFieldWithDoc('media'))}(serialize($paths));
        return $m;
    }

    protected function isValidRequest(?string $csrfName = null) : array
    {
        $data = $this->request->get();
        if ($data['csrftoken'] && $this->token->validate($data['csrftoken'], $csrfName == null ? $data['frm_name'] : $csrfName)) {
            return $data;
        }
        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Invalid csrf Token!')]);

        $this->jsonResponse(['result' => 'error', 'msg' => $this->helper->showMessage('warning', 'Invalid post Request!')]);
    }

    /**
     * Init controller.
     * ==================================================================.
     * @param array $params
     * @return void
     */
    protected function properties(array $params = []) : void
    {
        if (!empty($params)) {
            foreach ($params as $prop => $value) {
                if ($prop != '' && property_exists($this, $prop)) {
                    if (is_string($value) && (class_exists($value) || interface_exists($value))) {
                        if ($prop === 'dispatcher' || $prop === 'comment') {
                            $this->{$prop} = $this->container($value)->create();
                        } else {
                            $this->{$prop} = $this->container($value);
                        }
                    } else {
                        $this->{$prop} = $value;
                    }
                }
            }
        }
    }
}