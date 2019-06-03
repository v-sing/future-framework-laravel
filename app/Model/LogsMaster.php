<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/5/27 0027
 * Time: 17:23
 */

namespace App\Model;

use Future\Admin\Auth\Database\BaseModel;

class LogsMaster extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
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