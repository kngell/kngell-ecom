<?php

declare(strict_types=1);

abstract class AbstractEntity
{
    public function regenerateField(string $fieldName) : string
    {
        return lcfirst(implode('', array_map('ucfirst', explode('_', $fieldName))));
    }

    public function getSetter(string $fieldName)
    {
        return 'set' . ucfirst($this->regenerateField($fieldName));
    }

    public function getGetters(string $fieldName)
    {
        return 'get' . ucfirst($this->regenerateField($fieldName));
    }

    protected function getOriginalField(mixed $field)
    {
        return strtolower($this->CamelCaseToUnderscore($field));
    }

    protected function filterPropertyComment(false|string $comment) : string
    {
        if (is_string($comment)) {
            preg_match('/@(?<content>.+)/i', $comment, $content);
            $content = isset($content['content']) ? $content['content'] : '';

            return trim(str_replace('*/', '', $content));
        }

        return '';
    }

    protected function reflectionClass() : CustomReflectorInterface
    {
        return CustomReflector::getInstance();
    }

    protected function reflectionInstance() : ReflectionClass
    {
        return CustomReflector::getInstance()->reflectionInstance($this::class);
    }

    protected function assingParams(array $attrs, array $params) : self
    {
        foreach ($params as $field => $value) {
            $field = $this->regenerateField($field);
            if (is_string($field) && in_array($field, $attrs)) {
                $this->updateEntity($field, $value);
            }
        }

        return $this;
    }

    protected function assingEntity(array $attrs, array $params) :  self
    {
        foreach ($attrs as $attr) {
            $attr = $this->getOriginalField($attr);
            if (array_key_exists($attr, $params) && $params[$attr] !== null) {
                $value = $params[$attr];
                $attr = $this->regenerateField($attr);
                $this->updateEntity($attr, $value);
            }
        }

        return $this;
    }

    private function updateEntity(string $field, mixed $value)
    {
        $method = $this->getSetter($field);
        if (method_exists($this, $method)) {
            $type = $this->reflectionInstance()->getProperty($field)->getType()->getName();
            $result = match ($type) {
                'DateTimeInterface' => $this->$method($this->dateTimeFormat($field, $value)),
                'string' => is_array($value) ? $this->$method((string) $value[0]) : $this->$method((string) $value),
                'int' => $this->$method((int) $value),
                default => $this->$method($value)
            };
        }
    }

    private function dateTimeFormat(string $field, mixed $value) : DateTimeInterface
    {
        if (is_string($value)) {
            return new DateTime($value);
        }

        return $value;
    }

    private function CamelCaseToSeparator($value, $separator = ' ')
    {
        if (!is_scalar($value) && !is_array($value)) {
            return $value;
        }
        if (defined('PREG_BAD_UTF8_OFFSET_ERROR') && preg_match('/\pL/u', 'a') == 1) {
            $pattern = ['#(?<=(?:\p{Lu}))(\p{Lu}\p{Ll})#', '#(?<=(?:\p{Ll}|\p{Nd}))(\p{Lu})#'];
            $replacement = [$separator . '\1', $separator . '\1'];
        } else {
            $pattern = ['#(?<=(?:[A-Z]))([A-Z]+)([A-Z][a-z])#', '#(?<=(?:[a-z0-9]))([A-Z])#'];
            $replacement = ['\1' . $separator . '\2', $separator . '\1'];
        }

        return preg_replace($pattern, $replacement, $value);
    }

    private function CamelCaseToUnderscore($value)
    {
        return $this->CamelCaseToSeparator($value, '_');
    }

    private function CamelCaseToDash($value)
    {
        return $this->CamelCaseToSeparator($value, '-');
    }
}
