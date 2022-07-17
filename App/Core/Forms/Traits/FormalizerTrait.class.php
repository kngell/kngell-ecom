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
}