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
class BaseModel extends Model
{
    protected $dateFormat = 'U';

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
                    $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN ? ";
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

}