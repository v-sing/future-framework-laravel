<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/4/17 0017
 * Time: 15:02
 */

namespace Future\Admin\Controllers;

use Future\Admin\Auth\Database\AuthGroup;
class AdminController extends BackendController
{
    /**
     * @var null
     */
    protected $model = null;
    protected $childrenGroupIds = [];
    protected $childrenAdminIds = [];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Admin');
        $this->childrenAdminIds = $this->auth->getChildrenAdminIds(true);
        $this->childrenGroupIds = $this->auth->getChildrenGroupIds(true);

        $groupList = toArray(AuthGroup::where('id', 'in', $this->childrenGroupIds)->select());
    }

}