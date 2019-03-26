<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/26 0026
 * Time: 16:36
 */

namespace Future\Admin\Controllers;

use Future\Admin\Auth\Database\Config;
class ConfigController extends BackendController
{
    protected $model = null;
    protected $noNeedRight = ['check'];

    public function __construct(\Illuminate\Http\Request $request)
    {
        parent::__construct($request);
        $this->model = Model('Config');
    }

    /**
     * 系统配置
     */
    public function index()
    {
        $siteList = [];
        $groupList = Config::getGroupList();
        foreach ($groupList as $k => $v) {
            $siteList[$k]['name'] = $k;
            $siteList[$k]['title'] = $v;
            $siteList[$k]['list'] = [];
        }
        foreach ($this->model->get()->toArray() as $k => $v) {
            if (!isset($siteList[$v['group']])) {
                continue;
            }
            $value = $v;
            $value['title'] = __($value['title']);
            if (in_array($value['type'], ['select', 'selects', 'checkbox', 'radio'])) {
                $value['value'] = explode(',', $value['value']);
            }
            $value['content'] = json_decode($value['content'], TRUE);
            $siteList[$v['group']]['list'][] = $value;
        }
        $index = 0;
        foreach ($siteList as $k => &$v) {
            $v['active'] = !$index ? true : false;
            $index++;
        }

        $assign=[
            'siteList'=>$siteList,
            'typeList'=>Config::getTypeList(),
            'groupList'=>Config::getGroupList()
        ];
        return $this->view($assign);
    }
}