<?php

declare(strict_types=1);

trait ModelGetterAndSetterTrait
{
    /**
     * Get the value of container.
     */
    public function container(?string $class = null, array $args = []) : object
    {
        if (null != $class) {
            return Application::diGet($class, $args);
        }
        return Application::getInstance();
    }

    public function getMoney() : MoneyManager
    {
        return $this->money;
    }

    /**
     * Undocumented function.
     *
     * @return Entity
     */
    public function getEntity() : Entity
    {
        return $this->entity;
    }

    /**
     * Set the value of entity.
     *
     * @return  self
     */
    public function setEntity(Entity $entity) : self
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * Get Results
     * ===========================================================.
     * @return mixed
     */
    public function get_results() : mixed
    {
        return isset($this->_results) ? $this->_results : [];
    }

    /**
     * Get Col ID or TablschemaID.
     *
     * @return string
     */
    public function get_colID() : string
    {
        return isset($this->_colID) ? $this->_colID : '';
    }

    public function validationPasses() : bool
    {
        return $this->validates;
    }

    public function unsetProperty(string $p) : self
    {
        unset($this->$p);
        return $this;
    }

    public function getTableName() : string
    {
        return $this->tableSchema;
    }

    public function getLastID() : ?int
    {
        if (isset($this->_lasID)) {
            return $this->_lasID;
        }
        return null;
    }

    public function setLastID(int $lastID) : self
    {
        $this->_lasID = $lastID;
        return $this;
    }

    public function count() : int
    {
        return $this->_count;
    }

    public function setCount(int $count) : void
    {
        $this->_count = $count;
    }

    public function setResults(mixed $results) : void
    {
        $this->_results = $results;
    }

    public function getErrorMessages(array $newKeys = []) : array
    {
        return $this->response->transform_keys($this->validationErr, $newKeys);
    }

    /**
     * Soft Delete
     * =======================================================================.
     * @param [type] $value
     * @return self
     */
    public function softDelete($value) : self
    {
        $this->_softDelete = $value;
        return $this;
    }

    /**
     * Current Controller Method
     * =======================================================================.
     * @param string $value
     * @return self
     */
    public function current_ctrl_method(string $value) : self
    {
        $this->_current_ctrl_method = $value;
        return $this;
    }

    /**
     * Get Data Repository method
     * ===============================================================.
     * @return RepositoryInterface
     */
    public function getRepository() : RepositoryInterface
    {
        return $this->repository;
    }

    /**
     * Get the value of tableSchemaID.
     */
    public function getTableSchemaID() : string
    {
        return $this->tableSchemaID;
    }

    /**
     * Set the value of tableSchemaID.
     *
     * @return  self
     */
    public function setTableSchemaID(string $tableSchemaID) : self
    {
        $this->tableSchemaID = $tableSchemaID;
        return $this;
    }

    /**
     * Get the value of tableSchema.
     */
    public function getTableSchema() : string
    {
        return $this->tableSchema;
    }

    /**
     * Set the value of tableSchema.
     *
     * @return  self
     */
    public function setTableSchema(string $tableSchema) : self
    {
        $this->tableSchema = $tableSchema;
        return $this;
    }

    /**
     * Get the value of _colIndex.
     */
    public function getColIndex()
    {
        return $this->_colIndex;
    }

    /**
     * Set the value of _colIndex.
     */
    public function setColIndex($_colIndex): self
    {
        $this->_colIndex = $_colIndex;

        return $this;
    }
}