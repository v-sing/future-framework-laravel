<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/24
 * Time: 18:09
 */

namespace Future\Admin\Controllers;

use Illuminate\Http\Request;

class IndexController extends BackendController
{
    public function index(Request $request)
    {
//       dd( $request->input());
        return view('admin::test');
    }
}