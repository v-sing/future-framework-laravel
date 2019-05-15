<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/5/7 0007
 * Time: 10:32
 */

namespace Future\Admin\Form;


use Future\Admin\Form\Field\Button;
use Future\Admin\Form;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Traits\Macroable;

class Field implements Renderable
{
    use Macroable;

    protected $form = null;
    /**
     * 元素id
     * @var
     */
    protected $id;
    /**
     * 展示方式
     * @var array
     */
    protected $horizontal = true;
    /**
     * 设置比例
     * @var array
     */
    protected $width = [
        'label' => '2',
        'field' => '10'
    ];
    /**
     * 字段
     * @var
     */
    protected $column;
    /**
     * 值
     * @var
     */
    protected $value;
    /**
     * 原始列的数据
     * @var
     */
    protected $data;
    /**
     * 验证规则
     * @var string
     */
    protected $rule = '';
    /**
     * 单独验证字段
     * @var string
     */
    protected $check = '';
    /**
     *
     * @var string
     */
    protected $placeholder = '';

    /**
     * 表单元素的名字
     *
     * @var string
     */
    protected $elementName = '';

    /**
     * 外层div元素classes.
     *
     * @var array
     */
    protected $outerClass = [
        'col-xs-12', 'col-sm-4'
    ];

    protected $elementClass = [

    ];
    /**
     * 是否隐藏
     * @var bool
     */
    protected $display = true;

    /**
     * 标签class
     * @var array
     */
    protected $labelClass = [
        'col-xs-12', 'col-sm-2'
    ];
    /**
     * 在之后添加元素
     * @var string
     */
    protected $afterHtml = '';
    /**
     * 在之前添加元素
     * @var string
     */
    protected $beforeHtml = '';
    /**
     * 属性
     * @var array
     */
    protected $option = [];


    public function init(Form $form)
    {
        $this->form = $form;

    }

    public function field()
    {

    }

    /**
     * 按钮
     */
    public function button()
    {
        $button = new Button($this->form);
        return $button;
    }

    public function render()
    {

    }

    public function getOption()
    {
        return $this->option;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }
}