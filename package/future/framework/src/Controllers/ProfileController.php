<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/4/8 0008
 * Time: 11:22
 */

namespace Future\Admin\Controllers;


class ProfileController extends BackendController
{

    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('AdminLog');
    }

    public function index()
    {
        if (isAjax()) {

            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $this->model
                ->where($where)
                ->where('admin_id', $this->auth->id)
                ->orderby($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->where('admin_id', $this->auth->id)
                ->orderby($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $result = array("total" => $total, "rows" => $list);
            return json($result);
        } else {
            return $this->view();
        }


    }

    public function update()
    {

    }
}