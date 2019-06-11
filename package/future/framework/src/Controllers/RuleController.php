<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/6/11 0011
 * Time: 13:34
 */

namespace Future\Admin\Controllers;


class RuleController extends BackendController
{
    protected $model;

    public function index()
    {
        return $this->view();
    }
}