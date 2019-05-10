<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/5/10 0010
 * Time: 11:29
 */

namespace Future\Admin;


use Future\Admin\Form\Field;
use Illuminate\Contracts\Support\Renderable;
use Closure;

class Form implements Renderable
{
    protected $initCallback = null;

    /**
     * @param Closure $callback
     * @return mixed
     */
    public function action(Closure $callback)
    {
        $this->initCallback = new Field();
        if ($callback instanceof Closure) {
            $callback($this->initCallback);
        }
        return $this;
    }

    public function render()
    {
        dd($this->initCallback);exit;
        // TODO: Implement render() method.
    }
}