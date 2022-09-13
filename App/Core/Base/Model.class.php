<?php

declare(strict_types=1);
class Model extends AbstractModel
{
    use ModelTrait;

    private $_results;
    private int $_count;
    private bool $_softDelete = false;
    private bool $_deleted_item = false;
    private string $_current_ctrl_method = 'update';
    private int $_lasID;
    private bool $_flatDb;

    /**
     * Main Constructor
     * =======================================================================.
     * @param string $tableSchema
     * @param string $tableSchemaID
     */
    public function __construct(string $tableSchema, string $tableSchemaID, bool $flatDb = false)
    {
        $this->throwException($tableSchema, $tableSchemaID);
        $this->tableSchema = $tableSchema;
        $this->tableSchemaID = $tableSchemaID;
        $this->_flatDb = $flatDb;
        $this->properties();
        $this->_modelName = $this::class;
    }

    public function assign(array $data) : self
    {
        $this->entity->assign($data);

        return $this;
    }

    public function guardedID(): array
    {
        return [];
    }

    /**
     * Get Detail
     * ===========================================================.
     * @param mixed $id
     * @param string $colID
     * @return self|null
     */
    public function getDetails(mixed $id = null, string $colID = '', string $mode = 'class') : ?self
    {
        if ($id == null) {
            $en = $this->getEntity();
            if ($en->isInitialized($this->get_colID())) {
                $id = $en->{$en->getGetters($en->getColId())}();
            }
        }
        if (null == $id) {
            throw new BaseException("Impossible de trouver l'enregistrement souhaité");
        }
        $data_query = $this->table()
            ->where([$colID != '' ? $colID : $this->get_colID() => $id])
            ->return($mode)
            ->build();

        return $this->findFirst($data_query);
    }

    public function getAll() : ?self
    {
        return $this->find();
    }

    public function getAllByIndex(mixed $id, string $return = '') : ?self
    {
        $this->table()->where([$this->getColIndex() => $id])->return($return == '' ? 'class' : $return);

        return $this->getAll();
    }

    public function getAllWithSearchAndPagin(array $args) : self
    {
        return $this->findWithSearchAndPagin($args);
    }

    public function getUniqueId(string $colid_name = '', string $prefix = '', string $suffix = '', int $token_length = 24) : mixed
    {
        $output = $prefix . $this->token->generate($token_length) . $suffix;
        while ($this->getDetails($output, $colid_name)->count() > 0) :
            $output = $prefix . $this->token->generate($token_length) . $suffix;
        endwhile;

        return $output;
    }

    /**
     * Save Data insert or update
     * ============================================================.
     * @param array $params
     * @return ?object
     */
    public function save(?Entity $entity = null) : ?Object
    {
        $en = is_null($entity) ? $this->entity : $entity;
        if ($this->beforeSave($entity)) {
            if ($en->isInitialized($en->getColId())) {
                $en = $this->beforeSaveUpadate($en);
                $save = $this->update();
            } else {
                $en = $this->beforeSaveInsert($en);
                $save = $this->insert();
            }
            if ($save->count() > 0) {
                $params['saveID'] = $save ?? '';

                return $this->afterSave($params);
            }
        }

        return null;
    }

    public function validator(array $items = []) : void
    {
        $this->validator->validate($items, $this);
    }

    /**
     * Throw an exception
     * ================================================================.
     * @return void
     */
    public function throwException(string $tableSchema, string $tableSchemaID): void
    {
        if (empty($tableSchema) || empty($tableSchemaID)) {
            throw new BaseInvalidArgumentException('Your repository is missing the required constants. Please add the TABLESCHEMA and TABLESCHEMAID constants to your repository.');
        }
    }
}
