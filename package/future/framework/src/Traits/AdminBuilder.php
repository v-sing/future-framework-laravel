<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/22 0022
 * Time: 14:57
 */

namespace Future\Admin\Traits;


trait AdminBuilder
{

    /**
     * 获取单条记录
     * @param $condition
     * @return BaseModel|BaseModel[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getInfo($condition = [], $field = null)
    {
        return $this->where($condition)->first($field);
    }

    /**
     * 根据条件查询多条
     * @param $condition
     * @param null $field
     * @param string $order
     * @param string $group
     * @return BaseModel[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getQueryNew($condition, $field = null, $order = '', $group = '')
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