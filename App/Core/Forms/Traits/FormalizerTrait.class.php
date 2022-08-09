<?php

declare(strict_types=1);

trait FormalizerTrait
{
    /**
     * Add a model repository the form builder object.
     *
     * @param object|null $repository
     * @return static
     */
    public function addRepository(?object $repository = null): static
    {
        if ($repository !== null) {
            $this->dataRepository = $repository;
        }
        return $this;
    }

    /**
     * Expose the model repository to the form builder object.
     *
     * @return mixed
     */
    public function getRepository(): mixed
    {
        return $this->dataRepository;
    }

    public function setTemplate(string $template) : self
    {
        $this->template = $template;
        return $this;
    }

    public function getTemplate() : string
    {
        return $this->template;
    }

    /**
     * Get the value of print.
     */
    public function getPrint() : FormBuilderBlueprint
    {
        return $this->print;
    }

    /**
     * Set the value of print.
     *
     * @return  self
     */
    public function setPrint(FormBuilderBlueprint $print) : self
    {
        $this->print = $print;

        return $this;
    }

    /**
     * Undocumented function.
     *
     * @param string $fieldName
     * @return mixed
     */
    public function hasValue(string $fieldName): mixed
    {
        if (is_array($arrayRepo = $this->getRepository())) {
            return empty($arrayRepo[$fieldName]) ? '' : $arrayRepo[$fieldName];
        }
        if (is_object($objectRepo = $this->getRepository())) {
            return empty($objectRepo->$fieldName) ? '' : $objectRepo->$fieldName;
        } else {
            return false;
        }
    }

    /**
     * Set the value of csrfKey.
     *
     * @return  self
     */
    public function setCsrfKey(string $csrfKey) : self
    {
        $this->csrfKey = $csrfKey;
        return $this;
    }

    public function globalClasses(array $classes) : self
    {
        foreach ($classes as $key => $class) {
            $this->globalClasses[$key] = $class;
        }
        return $this;
    }

    public function wrapperClass(array $class = []) : self
    {
        if (!array_key_exists(__FUNCTION__, $this->htmlAttr)) {
            $this->htmlAttr[__FUNCTION__] = [];
        }
        if (!empty($class)) {
            foreach ($class as $classStr) {
                array_push($this->htmlAttr[__FUNCTION__], $classStr);
            }
        }
        return $this;
    }

    public function content(string $content) : self
    {
        $this->inputObject[0]->content($content);
        return $this;
    }

    public function rows(int $rows) : self
    {
        $this->inputObject[0]->rows($rows);
        return $this;
    }

    public function cols(int $rows) : self
    {
        $this->inputObject[0]->cols($rows);
        return $this;
    }

    public function removeDefaultClasses() : self
    {
        $this->htmlAttr['wrapperClass'] = isset($this->htmlAttr['wrapperClass']) ? [] : '';
        $this->htmlAttr['labelClass'] = isset($this->htmlAttr['labelClass']) ? [] : '';
        return $this;
    }

    public function noWrapper() : self
    {
        $this->inputObject[0]->settings(['field_wrapper' => false]);
        return $this;
    }

    public function noLabel() : self
    {
        $this->inputObject[0]->settings(['show_label' => false]);
        return $this;
    }

    public function templatePath(string $str) : self
    {
        $this->inputObject[0]->settings(['templatePath' => $str]);
        $this->inputObject[0]->templatesReset();
        return $this;
    }

    public function class(array $class = [])
    {
        if (count($this->inputObject) === 1) {
            if (!empty($class)) {
                foreach ($class as $classStr) {
                    $this->inputObject[0]->class($classStr);
                }
            }
        }
        return $this;
    }

    public function value(mixed $value)
    {
        $this->inputObject[0]->value($value);
        return $this;
    }

    public function placeholder(string $str) : self
    {
        if (count($this->inputObject) === 1) {
            $this->inputObject[0]->placeholder($str);
        }
        return $this;
    }

    public function label(string $str) : self
    {
        if (count($this->inputObject) === 1) {
            $this->inputObject[0]->settings(['label' => $str, 'show_label' => true]);
        }
        return $this;
    }

    public function labelClass(array $class = []) : self
    {
        if (count($this->inputObject) === 1) {
            if (!empty($class)) {
                foreach ($class as $classStr) {
                    array_push($this->htmlAttr[__FUNCTION__], $classStr);
                }
            }
        }
        return $this;
    }

    public function labelDescr(string $str) : self
    {
        if (count($this->inputObject) === 1) {
            $this->htmlAttr[__FUNCTION__] = [$str];
        }
        return $this;
    }

    public function req() : self
    {
        if (count($this->inputObject) === 1) {
            $this->inputObject[0]->req();
        }
        return $this;
    }

    public function attr(array $args = []) :self
    {
        if (count($args) !== 0) {
            $this->inputObject[0]->attr($args);
        }
        return $this;
    }

    public function spanClass(array $class = []) : self
    {
        if (count($this->inputObject) === 1) {
            if (!empty($class)) {
                foreach ($class as $classStr) {
                    array_push($this->htmlAttr[__FUNCTION__], $classStr);
                }
            }
        }
        return $this;
    }

    public function textClass(array $class = []) : self
    {
        if (!array_key_exists(__FUNCTION__, $this->htmlAttr)) {
            $this->htmlAttr[__FUNCTION__] = [];
        }
        if (count($this->inputObject) === 1) {
            if (!empty($class)) {
                foreach ($class as $classStr) {
                    array_push($this->htmlAttr[__FUNCTION__], $classStr);
                }
            }
        }
        return $this;
    }

    public function checked(bool $chk) : self
    {
        if (count($this->inputObject) === 1) {
            $this->inputObject[0]->checked($chk);
        }
        return $this;
    }

    public function labelUp(string $str) : self
    {
        if (count($this->inputObject) === 1) {
            $this->inputObject[0]->settings(['label' => $str, 'show_label' => true, 'label_up' => true]);
        }
        return $this;
    }

    public function id(string $id) : self
    {
        if (count($this->inputObject) === 1) {
            $this->inputObject[0]->id($id);
        }
        return $this;
    }

    public function useModel(bool $useModelData = false) : self
    {
        $this->inputObject[0]->useModel($useModelData);
        return $this;
    }

    /**
     * Get the value of csrfKey.
     */
    protected function getCsrfKey() : string
    {
        return $this->csrfKey;
    }

    protected function setGelobalClasses()
    {
        foreach ($this->globalClasses as $key => $class) {
            if ($key == 'wrapper') {
                !in_array($class, $this->htmlAttr['wrapperClass']) ? $this->wrapperClass($class) : '';
            }
            if (!in_array($this->inputObject[0]::class, ['SelectType', 'CheckBoxType', 'TextAreaType', 'RadioType', 'ButtonType'])) {
                if ($key == 'input') {
                    $this->class($class);
                }
            }
            if (!in_array($this->inputObject[0]::class, ['CheckBoxType', 'TextAreaType', 'RadioType', 'ButtonType'])) {
                if ($key == 'label') {
                    $this->labelClass($class);
                }
            }
        }
        return $this;
    }
}