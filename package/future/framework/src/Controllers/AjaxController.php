<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/5 0005
 * Time: 17:45
 */

namespace Future\Admin\Controllers;

use Illuminate\Http\Request;

class AjaxController extends BackendController
{
    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';

    /**
     * 返回语言
     * @return \Illuminate\Http\JsonResponse|\think\response\Jsonp
     */
    public function lang(Request $request)
    {
        $controller = $request->input('controllername');
        $this->loadLang($controller);
        return jsonp('define', config('ajax.lang'));
    }

    public function upload()
    {
        $fileCharater = $this->request->file('file');
        if($fileCharater->isValid()){


            //获取文件的扩展名
            $ext = $fileCharater->getClientOriginalExtension();

            //获取文件的绝对路径
            $path = $fileCharater->getRealPath();

        }
    }

    //初始化语言包
    protected function loadLang($controller)
    {
        $add   = trans('admin_vendor' . '::' . $controller);
        $array = [];
        if (is_array($add)) {
            $array = trans('admin_vendor' . '::' . $controller);
        }
        if (empty($array)) {
            $add = trans('admin' . '::' . $controller);
            if (is_array($add)) {
                $array = trans('admin' . '::' . $controller);
            }
        }
        $array = array_merge(trans('admin_vendor::' . config('app.locale')), $array);
        config(['ajax.lang' => $array]);
    }

    /**
     * 发送测试邮件
     */
    public function emailtest()
    {

    }
}