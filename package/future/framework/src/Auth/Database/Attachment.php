<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/22 0022
 * Time: 16:50
 */

namespace Future\Admin\Auth\Database;




class Attachment extends BaseModel
{
    public $timestamps = true;
    /**
     * 白名单
     * @var array
     */
    protected $fillable = ['*'];
    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        $this->setConnection($connection);
        $class = class_basename(get_class());
        $this->setTable(parse_underline($class));
        parent::__construct($attributes);
    }
}