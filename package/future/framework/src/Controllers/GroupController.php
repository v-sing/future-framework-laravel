<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/6/11 0011
 * Time: 11:50
 */

namespace Future\Admin\Controllers;

use Future\Admin\Facades\Admin;
use Future\Admin\Auth\Database\AuthGroup;

class GroupController extends BackendController
{
    protected $model;

    protected $noNeedRight = ['roletree'];

    protected function _initialize()
    {
        parent::_initialize();
        $this->model = model('AdminLog');
        $this->middleware('admin.adminController');
    }

    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        if(isAjax()){
            $groupdata = Admin::getAssign('groupdata');
            $list=AuthGroup::whereIn('id',array_keys($groupdata))->get()->toArray();
            $groupList = [];
            foreach ($list as $k => $v) {
                $groupList[$v['id']] = $v;
            }
            $list = [];
            foreach ($groupdata as $k => $v) {
                if (isset($groupList[$k])) {
                    $groupList[$k]['name'] = $v;
                    $list[] = $groupList[$k];
                }
            }
            $total = count($list);
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view();
    }

}