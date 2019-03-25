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

    /**
     * 公共模板
     * @var string
     */
    protected $layout = 'admin::layouts.site';
    /**
     * 要传递的参数
     * @var array
     */
    private $assign = [];
    /**
     * @var array|\Illuminate\Http\Request|null|string|\think\Request
     */
    protected $request = null;
    /**
     * 权限控制类
     * @var Auth
     */
    protected $auth = null;

    /**
     * 模型对象
     * @var \think\Model
     */
    protected $model = null;

    /**
     * 快速搜索时执行查找的字段
     */
    protected $searchFields = 'id';

    /**
     * 是否是关联查询
     */
    protected $relationSearch = false;

    /**
     * 是否开启数据限制
     * 支持auth/personal
     * 表示按权限判断/仅限个人
     * 默认为禁用,若启用请务必保证表中存在admin_id字段
     */
    protected $dataLimit = false;

    /**
     * 数据限制字段
     */
    protected $dataLimitField = 'admin_id';

    /**
     * 数据限制开启时自动填充限制字段值
     */
    protected $dataLimitFieldAutoFill = true;

    /**
     * 是否开启Validate验证
     */
    protected $modelValidate = false;

    /**
     * 是否开启模型场景验证
     */
    protected $modelSceneValidate = false;

    /**
     * Multi方法可批量修改的字段
     */
    protected $multiFields = 'status';

    /**
     * Selectpage可显示的字段
     */
    protected $selectpageFields = '*';

    /**
     * 导入文件首行类型
     * 支持comment/name
     * 表示注释或字段名
     */
    protected $importHeadType = 'comment';
    /**
     * 不验证权限的
     * @var array
     */
    protected $noNeedRight = ['login'];

    /**
     * 不验证登录
     * @var array
     */
    protected $noNeedLogin = ['login'];

    public function __construct(\Illuminate\Http\Request $request)
    {
        $request->merge(['nature' => [
            'noNeedRight' => $this->noNeedRight,
            'noNeedLogin' => $this->noNeedLogin
        ]]);

        $this->auth = Auth::instance();
        $this->middleware('admin.auth');
        $this->request = request();
    }
    /**
     * 向模板输出变量
     * @param $name
     * @param array $value
     */
    protected function assign($name, $value = array())
    {
        //如果name 是数组 且value 为空时
        if (is_array($name) && empty($value)) {
            $this->assign = array_merge($this->assign, $name);
        } else {
            $this->assign[$name] = $value;
        }
    }

    /**
     * 生成查询所需要的条件,排序方式
     * @param mixed $searchfields 快速查询的字段
     * @param boolean $relationSearch 是否关联查询
     * @param boolean $model 当前使用的主表model
     * @return array
     */
    protected function buildparams($searchfields = null, $relationSearch = null, $model = null)
    {
        $model          = is_null($model) ? $this->model : $model;
        $searchfields   = is_null($searchfields) ? $this->searchFields : $searchfields;
        $relationSearch = is_null($relationSearch) ? $this->relationSearch : $relationSearch;
        $search         = $this->request->get("search", '');
        $filter         = $this->request->get("filter", '');
        $op             = $this->request->get("op", '', 'trim');
        $sort           = $this->request->get("sort", "id");
        $order          = $this->request->get("order", "DESC");
        $offset         = $this->request->get("offset", 0);
        $limit          = $this->request->get("limit", 0);
        $filter         = (array)json_decode($filter, TRUE);
        $op             = (array)json_decode($op, TRUE);
        $filter         = $filter ? $filter : [];

        $where     = [];
        $tableName = '';
        if ($relationSearch) {
            if (!empty($model)) {
                $name      = \think\Loader::parseName(basename(str_replace('\\', '/', get_class($model))));
                $tableName = $name . '.';
            }
            $sortArr = explode(',', $sort);
            foreach ($sortArr as $index => & $item) {
                $item = stripos($item, ".") === false ? $tableName . trim($item) : $item;
            }
            unset($item);
            $sort = implode(',', $sortArr);
        }
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            $where[] = [$tableName . $this->dataLimitField, 'in', $adminIds];
        }
        if ($search) {
            $searcharr = is_array($searchfields) ? $searchfields : explode(',', $searchfields);
            foreach ($searcharr as $k => &$v) {
                $v = stripos($v, ".") === false ? $tableName . $v : $v;
            }
            unset($v);
            $where[] = [implode("|", $searcharr), "LIKE", "%{$search}%"];
        }
        foreach ($filter as $k => $v) {
            if ($k === 'categoryL1|categoryL2|categoryL3') {
                $array = explode('-', $v);
                $v     = $array[1];
            }
            $sym = isset($op[$k]) ? $op[$k] : '=';
            if (stripos($k, ".") === false) {
                $k = $tableName . $k;
            }
            $v   = !is_array($v) ? trim($v) : $v;
            $sym = strtoupper(isset($op[$k]) ? $op[$k] : $sym);
            switch ($sym) {
                case '=':
                case '!=':
                    $where[] = [$k, $sym, (string)$v];
                    break;
                case 'LIKE':
                case 'NOT LIKE':
                case 'LIKE %...%':
                case 'NOT LIKE %...%':
                    $where[] = [$k, trim(str_replace('%...%', '', $sym)), "%{$v}%"];
                    break;
                case '>':
                case '>=':
                case '<':
                case '<=':
                    $where[] = [$k, $sym, intval($v)];
                    break;
                case 'FINDIN':
                case 'FINDINSET':
                case 'FIND_IN_SET':
                    $where[] = "FIND_IN_SET('{$v}', " . ($relationSearch ? $k : '`' . str_replace('.', '`.`', $k) . '`') . ")";
                    break;
                case 'IN':
                case 'IN(...)':
                case 'NOT IN':
                case 'NOT IN(...)':
                    $where[] = [$k, str_replace('(...)', '', $sym), is_array($v) ? $v : explode(',', $v)];
                    break;
                case 'BETWEEN':
                case 'NOT BETWEEN':
                    $arr = array_slice(explode(',', $v), 0, 2);
                    if (stripos($v, ',') === false || !array_filter($arr))
                        continue;
                    //当出现一边为空时改变操作符
                    if ($arr[0] === '') {
                        $sym = $sym == 'BETWEEN' ? '<=' : '>';
                        $arr = $arr[1];
                    } else if ($arr[1] === '') {
                        $sym = $sym == 'BETWEEN' ? '>=' : '<';
                        $arr = $arr[0];
                    }
                    $where[] = [$k, $sym, $arr];
                    break;
                case 'RANGE':
                case 'NOT RANGE':
                    $v   = str_replace(' - ', ',', $v);
                    $arr = array_slice(explode(',', $v), 0, 2);
                    if (stripos($v, ',') === false || !array_filter($arr))
                        continue;
                    //当出现一边为空时改变操作符
                    if ($arr[0] === '') {
                        $sym = $sym == 'RANGE' ? '<=' : '>';
                        $arr = $arr[1];
                    } else if ($arr[1] === '') {
                        $sym = $sym == 'RANGE' ? '>=' : '<';
                        $arr = $arr[0];
                    }
                    $where[] = [$k, str_replace('RANGE', 'BETWEEN', $sym) . ' time', $arr];
                    break;
                case 'LIKE':
                case 'LIKE %...%':
                    $where[] = [$k, 'LIKE', "%{$v}%"];
                    break;
                case 'NULL':
                case 'IS NULL':
                case 'NOT NULL':
                case 'IS NOT NULL':
                    $where[] = [$k, strtolower(str_replace('IS ', '', $sym))];
                    break;
                default:
                    break;
            }
        }
        $where = function ($query) use ($where) {
            foreach ($where as $k => $v) {
                if (is_array($v)) {
                    call_user_func_array([$query, 'where'], $v);
                } else {
                    $query->where($v);
                }
            }
        };
        return [$where, $sort, $order, $offset, $limit];
    }

    /**
     * 加载模板
     * @param string $template
     * @param array $data
     * @return mixed
     */
    protected function view($data = [], $view = null)
    {
        if (!$view) {
            $path = Request::input('controller');
            $view = $path['module'] . '::' . $path['controller'] . '.' . $path['action'];
        }
        $data = array_merge($this->assign, $data, Request::input('assign'));
        if (is_null($this->layout)) {
            return  view($view)->with($data);
        } else {
            //加载公共模板
            if (!is_null($this->layout) && request()->isMethod('GET')) {
                $this->layout = View::make($this->layout,$data);
            }

            return $this->layout->nest('layouts', $view, $data);
        }
    }
}