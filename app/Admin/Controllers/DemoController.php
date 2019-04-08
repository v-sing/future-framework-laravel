<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/27 0027
 * Time: 15:18
 */

namespace App\Admin\Controllers;


use Future\Admin\Controllers\TestController;

class DemoController extends TestController
{
public function database(){
  return  $this->view();
}
}