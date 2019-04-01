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
}