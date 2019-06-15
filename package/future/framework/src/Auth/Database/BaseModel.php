<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/25 0025
 * Time: 15:59
 */

namespace Future\Admin\Auth\Database;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Future\Admin\Future\Loader;
use Future\Admin\Future\Exception\ValidateException;

class BaseModel extends Model
{
    // 错误信息
    protected $error;
    // 字段验证规则
    protected $validate;
    // 数据表主键 复合主键使用数组定义 不设置则自动获取
    protected $dateFormat = 'U';
    // 验证失败是否抛出异常
    protected $failException = false;
    // 是否采用批量验证
    protected $batchValidate = false;
    protected $error;

    /**
     * 获取单条记录
     * @param $condition
     * @return BaseModel|BaseModel[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getInfo($condition = [], $field = '*')
    {
        return $this->where($condition)->first($field);
    }

    public function data($param)
    {
        foreach ($param as $key => $value) {
            $this->$key = $value;
        }
        return $this;
    }

    /**
     * 根据条件查询多条
     * @param $condition
     * @param null $field
     * @param string $order
     * @param string $group
     * @return BaseModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getQueryNew($condition, $field = '*', $order = '', $group = '')
    {
        $model = $this->where($condition);
        if ($order != '') {
            $orderArray = explode(',', $order);
            foreach ($orderArray as $k => $v) {
                $childArray = explode(' ', trim($v, ' '));
                $columns    = $childArray[0];
                $desc       = $childArray[1] ? $childArray[1] : 'asc';
                $model->orderBy($columns, $desc);
            }
        }
        if ($group != '') {
            $model->groupBy($group);
        }
        return $model->get($field);
    }

    /**
     *
     * @return mixed
     */
    public function getPk()
    {
        return $this->primaryKey;
    }

    /**
     * 批量更新数据
     * @param array $multipleData
     * @return bool
     */
    public function updateBatch($multipleData = [])
    {
        try {
            if (empty($multipleData)) {
                throw new \Exception("数据不能为空");
            }
            $tableName = DB::getTablePrefix() . $this->getTable(); // 表名
            $firstRow  = current($multipleData);

            $updateColumn = array_keys($firstRow);
            // 默认以主键为条件更新，如果没有ID则以第一个字段为条件
            $referenceColumn = isset($firstRow[$this->getPk()]) ? $this->getPk() : current($updateColumn);
            unset($updateColumn[0]);
            // 拼接sql语句
            $updateSql = "UPDATE " . $tableName . " SET ";
            $sets      = [];
            $bindings  = [];
            foreach ($updateColumn as $uColumn) {
                $setSql = "`" . $uColumn . "` = CASE ";
                foreach ($multipleData as $data) {
                    $setSql     .= "WHEN `" . $referenceColumn . "` = ? THEN ? ";
                    $bindings[] = $data[$referenceColumn];
                    $bindings[] = $data[$uColumn];
                }
                $setSql .= "ELSE `" . $uColumn . "` END ";
                $sets[] = $setSql;
            }
            $updateSql .= implode(', ', $sets);
            $whereIn   = collect($multipleData)->pluck($referenceColumn)->values()->all();
            $bindings  = array_merge($bindings, $whereIn);
            $whereIn   = rtrim(str_repeat('?,', count($whereIn)), ',');
            $updateSql = rtrim($updateSql, ", ") . " WHERE `" . $referenceColumn . "` IN (" . $whereIn . ")";
            // 传入预处理sql语句和对应绑定数据
            return DB::update($updateSql, $bindings);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 设置字段验证
     * @access public
     * @param array|string|bool $rule 验证规则 true表示自动读取验证器类
     * @param array $msg 提示信息
     * @param bool $batch 批量验证
     * @return $this
     */
    public function validate($rule = true, $msg = [], $batch = false)
    {
        if (is_array($rule)) {
            $this->validate = [
                'rule' => $rule,
                'msg'  => $msg,
            ];
        } else {
            $this->validate = true === $rule ? $this->name : $rule;
        }
        $this->batchValidate = $batch;
        return $this;
    }

    /**
     * 设置验证失败后是否抛出异常
     * @access public
     * @param bool $fail 是否抛出异常
     * @return $this
     */
    public function validateFailException($fail = true)
    {
        $this->failException = $fail;
        return $this;
    }

    /**
     * 自动验证数据
     * @access protected
     * @param array $data 验证数据
     * @param mixed $rule 验证规则
     * @param bool $batch 批量验证
     * @return bool
     */
    protected function validateData($data, $rule = null, $batch = null)
    {
        $info = is_null($rule) ? $this->validate : $rule;

        if (!empty($info)) {
            if (is_array($info)) {
                $validate = Loader::validate();
                $validate->rule($info['rule']);
                $validate->message($info['msg']);
            } else {
                $name = is_string($info) ? $info : $this->name;
                if (strpos($name, '.')) {
                    list($name, $scene) = explode('.', $name);
                }
                $validate = Loader::validate($name);
                if (!empty($scene)) {
                    $validate->scene($scene);
                }
            }
            $batch = is_null($batch) ? $this->batchValidate : $batch;
            if (!$validate->batch($batch)->check($data)) {
                $this->error = $validate->getError();
                if ($this->failException) {
                    throw new ValidateException($this->error);
                } else {
                    return false;
                }
            }
            $this->validate = null;
        }
        return true;
    }
}