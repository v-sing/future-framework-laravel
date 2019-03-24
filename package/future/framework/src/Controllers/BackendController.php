<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/24
 * Time: 18:10
 */

namespace Future\Admin\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Future\Admin\Traits\Backend;
use Illuminate\Foundation\Bus\DispatchesJobs;
class BackendController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, Backend;
}