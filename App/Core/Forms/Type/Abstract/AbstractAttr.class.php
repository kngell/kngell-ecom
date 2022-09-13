<?php

declare(strict_types=1);

abstract class AbstractAttr
{
    protected array $attr = [];
    protected array $globalAttr;
    /** @var string - this is the standard Template */
    protected string $template = '';
    /** @var string - this is the standard Label Template */
    protected string $labelTemplate = '';
    /** @var string - this is the standard Label Template */
    protected string $labelTemplatePath = '';
    /** @var string - this is the standard Path */
    protected string $templatePath = '';

    public function settings(array $args) : self
    {
        foreach ($args as $key => $value) {
            $this->settings[$key] = $value;
        }

        return $this;
    }

    public function templatesReset()
    {
        if (isset($this->settings['templatePath'])) {
            $this->templatePath = $this->settings['templatePath'];
            unset($this->settings['templatePath']);
        }
        list($this->template, $this->labelTemplate) = $this->template($this->templatePath);
    }

    public function type(string $str) : self
    {
        $this->attr[__FUNCTION__] = $str;

        return $this;
    }

    public function placeholder(string $str) : self
    {
        $this->attr[__FUNCTION__] = $str;

        return $this;
    }

    public function value(mixed $value) : self
    {
        $this->attr['value'] = $value;

        return $this;
    }

    public function Label(string $label) : self
    {
        $this->settings['show_label'] = true;
        $this->settings['label'] = $label;

        return $this;
    }

    public function attr(array $args = []) : self
    {
        foreach ($args as $key => $value) {
            $this->attr[$key] = $value;
        }

        return $this;
    }

    public function class(array|string $class) : self
    {
        if (is_string($class)) {
            !in_array($class, $this->attr[__FUNCTION__]) ? array_push($this->attr[__FUNCTION__], $class) : '';
        } else {
            $currentClass = isset($this->settings[__FUNCTION__]) ? $this->settings[__FUNCTION__] : [];
            if (!is_array($class)) {
                throw new FormBuilderInvalidArgumentException("$class must be an array");
            }
            $this->settings[__FUNCTION__] = array_merge($currentClass, $class);
        }

        return $this;
    }

    public function checked(bool $chk = false) : self
    {
        $this->attr[__FUNCTION__] = $chk;

        return $this;
    }

    public function req() : self
    {
        $this->attr['required'] = true;

        return $this;
    }

    public function id(string $id) : self
    {
        $this->attr['id'] = $id;

        return $this;
    }

    public function useModel(bool $useModel) : self
    {
        $this->settings['model_data'] = $useModel;

        return $this;
    }

    public function content(string $content) : self
    {
        $this->attr['content'] = $content;

        return $this;
    }

    public function getContent() : string
    {
        return isset($this->attr['content']) ? $this->attr['content'] : '';
    }

    public function getTemplate() : string
    {
        return $this->template;
    }

    public function getLabelTemplate() : string
    {
        return $this->labelTemplate;
    }

    public function htmlAttr() : array
    {
        return [];
    }

    /**
     * Returns an array of base options.
     *
     * @return array
     */
    public function getBaseOptions() : array
    {
        return [
            'type' => $this->type,
            'name' => '',
            'id' => isset($this->attr['id']) ? $this->attr['id'] : '',
            'class' => ['form-control', isset($this->attr['id']) ? $this->attr['id'] : ($this->fields['name'] ?? '')],
            'checked' => false,
            'required' => false,
            'disabled' => false,
            'autofocus' => false,
            'autocomplete' => 'nope',
            'custom_attr' => '',
            'title' => '',
            'value' => '',
        ];
    }

    //input
    public function mergeArys(array ...$params) : array
    {
        $class = [];
        foreach ($params as $paramsAry) {
            if (isset($paramsAry['class']) && is_array($paramsAry['class'])) {
                $class = array_merge_recursive($class, $paramsAry['class']);
            }
            if (isset($paramsAry['pattern']) && is_bool($paramsAry['pattern'])) {
                $patternBool = $paramsAry['pattern'];
            } elseif (isset($paramsAry['pattern']) && !is_bool($paramsAry['pattern'])) {
                $pattern = $paramsAry['pattern'];
            }
        }
        $arr1 = array_merge(...$params);
        if (isset($patternBool) && $patternBool == true) {
            if (isset($pattern)) {
                $arr1['pattern'] = $pattern;
            }
        } elseif (isset($patternBool) && $patternBool == false) {
            if (isset($pattern)) {
                unset($arr1['pattern']);
            }
        }
        $arr1['class'] = $class;

        return $arr1;
    }

    protected function template() : array
    {
        if ((!empty($this->templatePath) && !file_exists($this->templatePath)) || (!empty($this->labelTemplatePath) && !file_exists($this->labelTemplatePath))) {
            throw new BaseException('Template Not Found!', 1);
        }

        return[
            !empty($this->templatePath) ? file_get_contents($this->templatePath) : '',
            !empty($this->labelTemplatePath) ? file_get_contents($this->labelTemplatePath) : '',
        ];
    }

    /**
     * Construct the extension namespace string. Extension name is captured from
     * the buildExtensionName() method name. Extension objects are also instantiated
     * from this method and check to ensure its implementing the correct interface
     * else will throw an invalid argument exception.
     *
     * @return void
     */
    protected function buildExtensionObject() : void
    {
        $getExtensionNamespace = __NAMESPACE__ . '\\' . $this->buildExtensionName();
        $getExtensionObject = new $getExtensionNamespace($this->fields);
        if (!$getExtensionObject instanceof FormExtensionTypeInterface) {
            throw new FormBuilderInvalidArgumentException($this->buildExtensionName() . ' is not a valid form extension type object.');
        }
    }

    /**
     * Construct the name of the extension type using the upper camel case
     * naming convention. Extension type name i.e Text will also be suffix
     * with the string (Type) so becomes TextType.
     *
     * @return string
     */
    protected function buildExtensionName() : string
    {
        $extensionName = lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $this->type . 'Type'))));

        return ucwords($extensionName);
    }

    protected function attrHtml() : string
    {
        $attribute = '';
        if (!empty($this->attr)) {
            foreach ($this->attr as $attr => $value) {
                if ($attr !== 'content') {
                    $space = empty($attribute) ? '' : ' ';
                    if (is_bool($value)) {
                        $attribute .= $value == true ? $space . $attr : '';
                    } elseif (is_array($value) && !empty($value)) {
                        $attribute .= $space . $attr . '=' . '"' . ltrim(implode(' ', $value)) . '"';
                    } else {
                        if (!empty($value)) {
                            $attribute .= $space . $attr . '=' . "'" . $value . "'";
                        }
                    }
                }
            }
            $attribute .= $this->getGlobalAttrHtml();
        }

        return $attribute;
    }

    private function getGlobalAttrHtml() : string
    {
        $attribute = '';
        if (isset($this->globalAttr) && !empty($this->globalAttr)) {
            foreach ($this->globalAttr as $key => $value) {
                if (is_array($value) && !empty($value)) {
                    $attribute .= ' ' . $key . '=' . '"' . implode($value) . '"';
                } elseif (!empty($value)) {
                    $attribute .= $key . '=' . $value;
                }
            }
        }

        return $attribute;
    }
}
