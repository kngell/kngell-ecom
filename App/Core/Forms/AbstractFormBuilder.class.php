<?php

declare(strict_types=1);

abstract class AbstractFormBuilder implements FormBuilderInterface
{
    /** @var array - constants which defines the various parts the form element */
    const FORM_PARTS = [
        'action' => '',
        'method' => 'post',
        'accept-charset' => '',
        'enctype' => 'application/x-www-form-urlencoded',
        'id' => '',
        'class' => [''],
        'rel' => '',
        'target' => '_self', /* defaults loads into itself */
        'novalidate' => true,
        'autocomplete' => 'nope',
        'leave_form_open' => false,
        //"onSubmit" => "UIkitNotify()"
    ];

    /** class constants for allowable field/input types */
    const SUPPORT_INPUT_TYPES = [
        'textarea',
        'select',
        'checkbox',
        'multiple_checkbox',
        'button',
        'radio',
        'text',
        'range',
        'number',
        'datetime-local',
        'time',
        'date',
        'input',
        'password',
        'email',
        'color',
        'button',
        'reset',
        'submit',
        'tel',
        'search',
        'url',
        'file',
        'month',
        'week',
        'hidden',
        'phone',
    ];
    /** @var array */
    const HTML_ELEMENT_PARTS = [
        'wrapperClass' => ['input-box', 'mb-3'],
        'wrapperId' => '',
        'feedbackTag' => '<div class="invalid-feedback form-text"></div>',
        'labelTag' => '%s {{label}}',
        'helpBlock' => '',
        'labelClass' => [],
        'require' => '<span class="text-danger">*</span>',
        'spanClass' => ['span_class'],
        'labelId' => '',
        'before' => '',
        'after' => '',
        'element' => 'div',
        'element_class' => ['input-wrapper'],
        'element_id' => '',
        'element_style' => '',
    ];
    /** @var array */
    const FIELD_ARGS = [
        'before' => '<div class="input-box mb-3">',
        'after' => '</div>',
    ];

    /** @var array */
    protected array $inputs = [];
    /** @var array */
    protected array $formAttr = [];
    /** @var array */
    protected array $globalClasses = [];

    /**
     * Main class constructor.
     */
    public function __construct()
    {
    }

    /**
     * Set the form input attributes if any attribute if left empty
     * then it will use the default if any is set.
     *
     * @param string $key
     * @param $value
     * @return bool
     */
    public function set(string $key, $value): bool
    {
        if (empty($key)) {
            throw new FormBuilderInvalidArgumentException('Invalid or empty attribute key. Ensure the key is present and valid');
        }
        switch ($key):
            case 'type':
                if (!in_array($value, self::SUPPORT_INPUT_TYPES)) {
                    throw new FormBuilderInvalidArgumentException('Unsupported object type ' . $value);
                }
        break;
        default:
                return false;
        break;
        endswitch;

        $this->inputs[$key] = $value;
        return true;
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
     * @param string $key
     * @param $value
     * @return bool
     */
    public function setAttributes(string $key, $value): bool
    {
        if (empty($key)) {
            throw new FormBuilderInvalidArgumentException('Invalid or empty attribute key. Ensure the key is present and valid');
        }
        switch ($key):
            case 'action':
                if (!is_string($key)) {
                    throw new FormBuilderInvalidArgumentException('Invalid action key. This must be a string.');
                }
        break;
        case 'method':
                if (!in_array($value, ['post', 'get', 'dialog'])) {
                    throw new FormBuilderInvalidArgumentException('Invalid form method. Either this is not set or you\'ve set an unsupported method type.');
                }
        break;
        case 'target' :
                if (!in_array($value, ['_self', '_blank', '_parent', '_top'])) {
                    throw new FormBuilderInvalidArgumentException('Invalid key');
                }
        break;
        case 'enctype':
                if (!in_array($value, ['application/x-www-form-urlencoded', 'multipart/form-data', 'text/plain'])) {
                    throw new FormBuilderInvalidArgumentException();
                }
        break;
        case 'id':
            case 'class':
                break;
        case 'novalidate':
            // case 'autocomplete' :
                if (!is_bool($value)) {
                    throw new FormBuilderInvalidArgumentException();
                }
        break;
        default:
                return false;
        break;
        endswitch;
        $this->formAttr[$key] = $value;
        return true;
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
                if ($key == 'label') {
                    $this->labelClass($class);
                }
            }
        }
        return $this;
    }
}