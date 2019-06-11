<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/6/11 0011
 * Time: 13:34
 */

namespace Future\Admin\Controllers;

use Future\Admin\Facades\Admin;
use Future\Admin\Fast\Tree;

class RuleController extends BackendController
{
    protected $model;
    protected $multiFields = 'ismenu,status';
    protected $rulelist = [];

    protected function _initialize()
    {
        parent::_initialize();
        $this->model = model('AuthRule');
        // 必须将结果集转换为数组
        $ruleList = $this->model->orderBy('weigh', 'desc')->orderBy('id', 'asc')->get()->toArray();
        foreach ($ruleList as $k => &$v) {
            $v['title']  = lang($v['title']);
            $v['remark'] = lang($v['remark']);
        }
        unset($v);
        Tree::instance()->init($ruleList);
        $this->rulelist = Tree::instance()->getTreeList(Tree::instance()->getTreeArray(0), 'title');
        $ruledata       = [0 => lang('None')];
        foreach ($this->rulelist as $k => &$v) {
            if (!$v['ismenu']) {
                continue;
            }
            $ruledata[$v['id']] = $v['title'];
        }
        unset($v);
        Admin::setAssign([
            'ruledata' => $ruledata
        ]);
    }

    public function index()
    {
        if (isAjax()) {
            $list   = $this->rulelist;
            $total  = count($this->rulelist);
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view();
    }
}