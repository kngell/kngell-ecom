<?php

declare(strict_types=1);

trait DisplayTraits
{
    protected function properties(array $params = []) : void
    {
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                if (property_exists($this, $key)) {
                    list($this->{$key}) = $this->invoke([$value]);
                }
            }
        }
    }

    protected function invoke(array $args = []) : array
    {
        $resp = [];
        if (!empty($args)) {
            foreach ($args as $arg) {
                if ($arg instanceof Closure) {
                    $resp[] = $arg->__invoke();
                } else {
                    $resp[] = $arg;
                }
            }
        }
        return $resp;
    }

    protected function isFileexists(string $file) : bool
    {
        if (!file_exists($file)) {
            throw new BaseException('File does not exist!', 1);
        }
        return true;
    }

    protected function getTemplate(string $path) : string
    {
        $this->isFileexists($this->paths->offsetGet($path));
        return file_get_contents($this->paths->offsetGet($path));
    }

    protected function media(object $obj) : string
    {
        if (isset($obj->media) && !is_null($obj->media)) {
            $media = !is_array($obj->media) ? unserialize($obj->media) : $obj->media;
            if (is_array($media) && count($media) > 0) {
                return str_starts_with($media[0], IMG) ? $media[0] : ImageManager::asset_img($media[0]);
            }
        }
        return '';
    }

    protected function customer(?Customer $customer = null) : ?Customer
    {
        $session = Container::getInstance()->make(SessionInterface::class);
        if (null !== $customer && $customer->getEntity()->isInitialized('address')) {
            if ($customer->getEntity()->{$customer->getEntity()->getGetters('address')}()->count() > 0) {
                return $customer;
            }
        }
        if ($session->exists(CHECKOUT_PROCESS_NAME)) {
            $customerEntity = unserialize($session->get(CHECKOUT_PROCESS_NAME));
            $customer = $customer->setEntity($customerEntity);
            return $customer;
        }
        if (null !== $customer) {
            return $customer;
        }
        throw new BaseException('Customer does not exist!');
    }
}