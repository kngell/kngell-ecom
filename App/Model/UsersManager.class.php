<?php

declare(strict_types=1);
class UsersManager extends Model
{
    protected $_colID = 'user_id';
    protected $_table = 'users';
    protected $_colIndex = '';
    protected $_colContent = '';
    protected $_media_img = 'profileImage';

    public function __construct()
    {
        parent::__construct($this->_table, $this->_colID);
    }

    public function get_selectedOptions(?Model $m = null)
    {
        /** @var Model */
        $groups = $this->container->make(GroupsMaganer::class);
        $query_params = $groups->table()->join('group_user', ['user_id', 'group_id'])
            ->on(['gr_id', 'group_id'])
            ->where(['user_id' => [$m->getEntity()->{'getUserId'}(), 'group_user']])
            ->return('class')
            ->build();
        $user_roles = $groups->getAll($query_params);
        $response = [];
        if ($user_roles->count() >= 1) {
            foreach ($user_roles->get_results() as $role) {
                $response[$role->groupID] = $role->name;
            }
        }
        $user_roles = null;

        return $response ? $response : [];
    }

    public function singleUser(int $id = -1) : ?self
    {
        if (!($id < 0)) {
            $this->table()->leftJoin('user_extra_data', ['u_descr', 'u_comment', 'gender', 'dob', 'u_function'])
                ->on(['user_id', 'user_id'])
                ->where(['user_id' => $id])
                ->return('class');
            $u = $this->getAll();
            if ($u->count() === 1) {
                return $u->assign((array) current($u->get_results()));
            }
        }

        return null;
    }
}
