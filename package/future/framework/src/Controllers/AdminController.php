<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/4/17 0017
 * Time: 15:02
 */

namespace Future\Admin\Controllers;


use Illuminate\Http\Request;
use Future\Admin\Facades\Admin;
use Future\Admin\Auth\Database\AuthGroup;
use Future\Admin\Auth\Database\AuthGroupAccess;
use Illuminate\Support\Facades\DB;

class AdminController extends BackendController
{
    /**
     * @var null
     */
    protected $model = null;
    protected $childrenGroupIds = [];
    protected $childrenAdminIds = [];

    protected function _initialize()
    {
        parent::_initialize();
        $this->model = model('Admin');
        $this->middleware('admin.adminController');
    }

    public function index(Request $request)
    {
        if (isAjax()) {
            $childrenAdminIds = Admin::getAssign('childrenAdminIds');
            $adminGroupName = $this->auth->getGroupAll();
            list($where, $sort, $order, $offset, $limit) = $this->buildparams('id,username,nickname,email,status,logintime');
            $total = $this->model
                ->where($where)
                ->whereIn('id', $childrenAdminIds)
                ->orderby($sort, $order)
                ->count();
            $list = $this->model
                ->where($where)
                ->whereIn('id', $childrenAdminIds)
                ->orderby($sort, $order)
                ->offset($offset)
                ->limit($limit)
                ->get();
            foreach ($list as $k => &$v) {
                unset($v['password']);
                unset($v['token']);
                unset($v['salt']);
                $groups           = isset($adminGroupName[$v['id']]) ? $adminGroupName[$v['id']] : [];
                $v['groups']      = implode(',', array_keys($groups));
                $v['groups_text'] = implode(',', array_values($groups));
            }
            unset($v);
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view();
    }
}