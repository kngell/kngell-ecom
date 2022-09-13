<?php

declare(strict_types=1);

abstract class AbstractModel
{
    use ModelGetterAndSetterTrait;
    protected string $_modelName;
    protected QueryParams $queryParams;
    protected RepositoryInterface|FileStorageRepositoryInterface $repository;
    protected ContainerInterface $container;
    protected MoneyManager $money;
    protected Entity $entity;
    protected ModelHelper $helper;
    protected SessionInterface $session;
    protected CookieInterface $cookie;
    protected CacheInterface $cache;
    protected Token $token;
    protected RequestHandler $request;
    protected ResponseHandler $response;
    protected Validator $validator;
    protected bool $validates = true;
    protected array $validationErr = [];
    protected string $tableSchema;
    protected string $tableSchemaID;

    /*
     * Prevent Deleting Ids
     * ------------------------------------------------------------.
     * @return array
     */
    abstract public function guardedID() : array;

    public function table(?string $tbl = null, mixed $columns = null) : QueryParams
    {
        return $this->getQueryParams()->table($tbl, $columns);
    }

    // public function recursiveTable(?string $tbl = null, mixed $columns = null, ?string $recursive = 'table_join') : QueryParams
    // {
    //     return (new QueryParams($this->tableShema))->table($tbl, $columns, $recursive);
    // }

    public function tableRecursive(?string $tbl = null, mixed $columns = null) : QueryParams
    {
        return $this->getQueryParams()->table($tbl, $columns, 'table_recursive');
    }

    public function conditions() : self
    {
        if ($this->queryParams->hasConditions()) {
            return $this;
        }
        $colID = $this->entity->getColId();
        if (!$this->entity->isInitialized($colID)) {
            throw new BaseException('unable to update row!');
        }
        $this->table()->where([$colID => $this->entity->{$this->entity->getGetters($colID)}()])->build();

        return $this;
    }

    /*
     * Global Before Save
     * ================================================================.
     * @return void
     */
    public function beforeSave() : mixed
    {
        if (isset(AuthManager::$currentLoggedInUser->userID) && property_exists($this, 'userID')) {
            if (!isset($this->userID) || empty($this->userID) || $this->userID == null) {
                $this->userID = AuthManager::$currentLoggedInUser->userID;
            }
        }
        if (isset($this->msg)) {
            unset($this->msg);
        }
        if (isset($this->fileErr)) {
            unset($this->fileErr);
        }

        return true;
    }

    public function beforeSaveUpadate(Entity $entity) : Entity
    {
        $f = $entity; //fields;
        // $current = new DateTime();
        // $key = current(array_filter(array_keys($fields), function ($field) {
        //     return str_starts_with($field, 'update');
        // }));
        // if ($key && !is_array($key)) {
        //     $f[$key] = $current->format('Y-m-d H:i:s');
        // }
        // if (isset($f[$this->get_colID()])) {
        //     unset($f[$this->get_colID()]);
        // }
        return $f;
    }

    public function beforeSaveInsert(Entity $entity)
    {
        return $entity;
    }

    public function afterSave(array $params = [])
    {
        return $params['saveID'] ? $this : null;
    }

    //Before delete
    public function beforeDelete(Entity $entity)
    {
        return !is_null($entity) ? true : false;
    }

    //After delete
    public function afterDelete($params = [])
    {
        $params = null;

        return true;
    }

    /*
     * Get Col ID or TablschemaID.
     *
     * @return string
     */
    public function get_colID() : string
    {
        return isset($this->_colID) ? $this->_colID : '';
    }

    public function runValidation(CustomValidator $validator) : void
    {
        $status = $validator->run();
        if (!$status) {
            $this->validates = false;
            $this->validationErr[$validator->getField()] = $validator->getMsg();
        }
    }

    /**
     * Get Container.
     *
     * @return ContainerInterface
     */
    public function get_container() : ContainerInterface
    {
        return $this->container;
    }

    public function getModelName() : string
    {
        return $this->_modelName;
    }

    public function getTableColumn() : array
    {
        $columns = $this->repository->get_tableColumn(['return_mode' => 'object']);
        if ($columns->count() > 0) {
            $columnsName = [];
            foreach ($columns->get_results() as $column) {
                $columnsName[] = '$' . $column->Field;
            }
        }

        return $columnsName;
    }
}
