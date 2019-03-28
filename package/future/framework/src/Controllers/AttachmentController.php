<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/28
 * Time: 21:26
 */

namespace Future\Admin\Controllers;
/**
 * 附件管理
 *
 * @icon fa fa-circle-o
 * @remark 主要用于管理上传到又拍云的数据或上传至本服务的上传数据
 */
class AttachmentController extends BackendController
{


    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('Attachment');
    }

    public function index()
    {

        return $this->view();
    }
}