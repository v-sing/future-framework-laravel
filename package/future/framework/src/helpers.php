<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/22 0022
 * Time: 10:47
 */

use Illuminate\Support\Facades\Request;
use Future\Admin\Facades\Admin;
if (!function_exists('lang')) {
    function lang($name, $vars = [])
    {
        $array = config('admin.lang');
        $name  = isset($array[$name]) ? $array[$name] : $name;
        if (!is_array($vars)) {
            $vars = func_get_args();
            array_shift($vars);
        }
        if (!empty($vars)) {
            foreach ($vars as $var) {
                $name = sprintf($name, $var);
            }
        }
        return $name;
    }
}

if (!function_exists('toArray')) {
    /**
     * 对象转数组
     * @param $data
     * @return mixed
     */
    function toArray($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = toArray($value);
            }
        }
        return $array;
    }
}

if (!function_exists('error')) {
    /**
     * @param string $msg
     * @param array $data
     * @param string $url
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\think\response\Redirect
     */

    function error($msg = 'operation failed!', $data = [], $url = '')
    {
        $data = [
            'code' => 0,
            'msg'  => lang($msg),
            'data' => $data,
            'url'  => $url
        ];
        if (isPost() || isAjax()) {
            return response()->json($data);
        } else {
            if ($url == '') {
                $data['url'] = Request::url();
            } else {
                $data['url'] = url($data['url']);
            }
            return redirect('admin/message')->with('msg', $data);
        }
    }
}

if (!function_exists('success')) {
    /**
     * @param string $msg
     * @param array $data
     * @param string $url
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\think\response\Redirect
     */
    function success($msg = 'Successful operation!', $data = [], $url = '')
    {
        $data = [
            'code' => 1,
            'msg'  => lang($msg),
            'data' => $data,
            'url'  => $url
        ];
        if (isPost() || isAjax()) {
            return response()->json($data);
        } else {
            if ($url == '') {
                $data['url'] = Request::url();
            } else {
                $data['url'] = url($data['url']);
            }
            return redirect('admin/message')->with('msg', $data);
        }
    }
}
if (!function_exists('isAjax')) {
    /**
     * @return bool
     */
    function isAjax()
    {
        return request()->isMethod('ajax');
    }
}

if (!function_exists('isPost')) {
    /**
     * @return bool
     */
    function isPost()
    {
        return request()->isMethod('post');
    }
}

if (!function_exists('isGet')) {
    /**
     * @return bool
     */
    function isGet()
    {
        return request()->isMethod('GET');
    }
}

if (!function_exists('jsonp')) {
    /**
     *
     * @param $callback
     * @param array $data
     * @param int $status
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    function jsonp($callback, $data = [], $status = 200, array $headers = [], $options = 0)
    {
        return response()->jsonp($callback, $data, $status, $headers, $options);
    }
}

if (!function_exists('admin_path')) {

    /**
     * Get admin path.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_path($path = '')
    {
        return ucfirst(config('admin.directory')) . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('admin_url')) {
    /**
     * Get admin url.
     *
     * @param string $path
     * @param mixed $parameters
     * @param bool $secure
     *
     * @return string
     */
    function admin_url($path = '', $parameters = [], $secure = null)
    {
        if (\Illuminate\Support\Facades\URL::isValidUrl($path)) {
            return $path;
        }

        $secure = $secure ?: (config('admin.https') || config('admin.secure'));

        return url(admin_base_path($path), $parameters, $secure);
    }
}

if (!function_exists('admin_base_path')) {
    /**
     * Get admin url.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_base_path($path = '')
    {
        $prefix = '/' . trim(config('admin.route.prefix'), '/');

        $prefix = ($prefix == '/') ? '' : $prefix;

        $path = trim($path, '/');

        if (is_null($path) || strlen($path) == 0) {
            return $prefix ?: '/';
        }

        return $prefix . '/' . $path;
    }
}
if (!function_exists('parse_hump')) {
    /**
     * 下划线转驼峰
     * @param $underline
     * @return mixed
     */
    function parse_hump($underline)
    {
        $underline = camel_case($underline);
        $underline = ucfirst($underline);
        return $underline;
    }
}

if (!function_exists('parse_underline')) {
    /**
     * 驼峰转下划线
     * @param $hump
     * @return mixed
     */
    function parse_underline($hump)
    {
        $hump = snake_case($hump);
        $hump = strtolower($hump);
        return $hump;
    }
}

if (!function_exists('build_heading')) {

    /**
     * 生成页面Heading
     *
     * @param string $path 指定的path
     * @return string
     */
    function build_heading($path = NULL, $container = TRUE)
    {


        $title      = $content = '';
        if (is_null($path)) {
            $action     = Admin::action();
            $controller = str_replace('.', '/', Admin::controller());
            $path       = strtolower($controller . ($action && $action != 'index' ? '/' . $action : ''));
        }
        // 根据当前的URI自动匹配父节点的标题和备注
        $data = Model('AuthRule')->getInfo(['name' => $path]);
        if ($data) {
            $title   = lang($data['title']);
            $content = lang($data['remark']);
        }
        if (!$content)
            return '';
        $result = '<div class="panel-lead"><em>' . $title . '</em>' . $content . '</div>';
        if ($container) {
            $result = '<div class="panel-heading">' . $result . '</div>';
        }
        return $result;
    }
}
if (!function_exists('Model')) {
    /**
     * 数据库层
     * @param $model
     * @return mixed
     */
    function Model($model)
    {
        if (!class_exists($class = '\\App\\Model\\' . $model)) {
            $class = '\\Future\\Admin\\Auth\\Database\\' . $model;
        }
        return new $class;
    }
}

if (!function_exists('admin_error')) {

    /**
     * Flash a error message bag to session.
     *
     * @param string $title
     * @param string $message
     */
    function admin_error($title, $message = '')
    {
        admin_info($title, $message, 'error');
    }
}

if (!function_exists('input')) {
    /**
     * 获取输入数据 支持默认值和过滤
     * @param string    $key 获取的变量名
     * @param mixed     $default 默认值
     * @param string    $filter 过滤方法
     * @return mixed
     */

    function input($key = '', $default = null, $filter = '')
    {
        return Request::input();
        if(request()->has($key)){
           return request()->input();
        }
    }
}
