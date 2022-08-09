<?php

declare(strict_types=1);

class RadioType extends AbstractAttr implements FormBuilderTypeInterface
{
    use FormBuilderTrait;

    /** @var string - returns the name of the extension. IMPORTANT */
    protected string $type = 'radio';
    /** @var array - return an array of form fields attributes */
    protected array $fields = [];
    /** @var array returns an array of form settings */
    protected array $settings = [];
    /** @var mixed */
    protected mixed $options = null;
    /** @var array returns an array of default options set */
    protected array $baseOptions = [];
    /** @var string - this is the standard Path */
    protected string $templatePath = FILES . 'Template' . DS . 'Base' . DS . 'Forms' . DS . 'FieldsTemplate' . DS . 'InputRadioTemplate.php';
    /** @var string - this is the standard Label Template */
    protected string $labelTemplatePath = '';

    /**
     * @param array $fields
     * @param mixed|null $options
     * @param array $settings
     */
    public function __construct(array $fields, mixed $options = null, array $settings = [])
    {
        $this->fields = $this->filterArray($fields);
        $this->options = ($options != null) ? $options : null;
        $this->settings = $settings;
        if (is_array($this->baseOptions)) {
            $this->baseOptions = $this->getBaseOptions();
        }
        list($this->template, $this->labelTemplate) = $this->template();
    }

    /**
     * Returns an array of base options.
     *
     * @return array
     */
    public function getBaseOptions() : array
    {
        return [
            'type' => 'radio',
            'name' => '',
            'id' => ($this->fields['name'] ?? ''),
            'class' => ['form-check-input'],
            'value' => '',
        ];
    }

    public function htmlAttr() : array
    {
        return [];
    }

    /**
     * Options which are defined for this object type
     * Pass the default array to the parent::configureOptions to merge together.
     *
     * @param array $options
     * @return void
     */
    public function configureOptions(array $options = []): void
    {
        $defaultWithExtensionOptions = (!empty($options) ? array_merge($this->baseOptions, $options) : $this->baseOptions);
        if ($this->fields) {
            $this->throwExceptionOnBadInvalidKeys($this->fields, $defaultWithExtensionOptions, __CLASS__);
            $this->attr = $this->mergeArys($defaultWithExtensionOptions, $this->fields, !empty($this->attr) ? $this->attr : []);
        }
    }

    /**
     * Publicize the default object type to other classes.
     *
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * Publicize the default object options to the base class.
     *
     * @return array
     */
    public function getOptions() : array
    {
        return $this->attr;
    }

    /**
     * Return the third argument from the add() method. This array can be used
     * to modify and filter the final output of the input and HTML wrapper.
     *
     * @return array
     */
    public function getSettings() : array
    {
        $defaults = [
            'container' => true,
            'show_label' => true,
            'new_label' => '',
            'field_wrapper' => true,
            'input_wrapper' => false,
            'label_up' => false,
            'label' => '',
            'require' => false,
            'model_data' => false,
        ];
        return !empty($this->settings) ? array_merge($defaults, $this->settings) : $defaults;
    }

    /**
     * The pre filter method provides a way to filtered the build field input
     * on a a per object type basis as all types share the same basic tags.
     *
     * there are cases where a tag is not required or valid within a
     * particular input/field. So we can filter it out here before being sent
     * back to the controller class
     *
     * @return string - return the filtered or unfiltered string
     */
    public function filtering(): string
    {
        return $this->renderInputOptions($this->attr, $this->options);
    }

    public function renderInputOptions(array $attr, $options = null, mixed $displayLabel = null): bool|string
    {
        $checked = isset($attr['checked']) && $attr['checked'] == true ? 'checked' : '';
        $value = isset($this->attr['value']) ? 'value="' . $this->attr['value'] . '" ' : '';
        return '<input type="' . $attr['type'] . '" name="' . $attr['name'] . '" id="' . $attr['id'] . '" class="' . implode(' ', $attr['class']) . '" ' . $value . $checked . ' />' . "\n";
    }

    /**
     * Render the form view to the builder method within the base class.
     *
     * @return string
     */
    public function view(): string
    {
        return sprintf('%s', $this->filtering());
    }
}