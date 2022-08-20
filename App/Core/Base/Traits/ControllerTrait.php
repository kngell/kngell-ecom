<?php

declare(strict_types=1);

trait ControllerTrait
{
    /**
     * Get the value of commentOutput.
     */
    public function outputComments() : array
    {
        return array_filter($this->customProperties, function ($prop) {
            return in_array($prop, ['comments']);
        }, ARRAY_FILTER_USE_KEY);
    }

    public function container(?string $class = null, array $args = []) : object
    {
        if (null != $class) {
            return Application::diGet($class, $args);
        }
        return Application::getInstance();
    }

    public function selectItem(CartManager|int $m) : CollectionInterface
    {
        /** @var CollectionInterface */
        $shopping_cart = $this->getUserCart();
        $shopping_cart = $shopping_cart->filter(function ($sc) use ($m) {
            if (is_int($m)) {
                return $sc->item_id === $m;
            }
            /** @var CartEntity */
            $en = $m->getEntity();
            return $sc->item_id === $en->getItemId();
        });
        return $shopping_cart;
    }

    protected function isIncommingDataValid(object $m, string $ruleMethod, array $newKeys = []) : void
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
        $setter = $m->getEntity()->getSetter($m->getEntity()->getColId('media'));
        $m->getEntity()->{$setter}(serialize($paths));
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