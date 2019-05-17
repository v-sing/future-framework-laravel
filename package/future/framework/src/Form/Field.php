<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/5/7 0007
 * Time: 10:32
 */

namespace Future\Admin\Form;


//use Future\Admin\Form\Field\Button;
use Future\Admin\Form;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Traits\Macroable;
use Future\Admin\Traits\FieldView;

class Field implements Renderable
{
    use Macroable, FieldView;
    protected $model = null;
    protected $data = [];
    protected $form = null;
    /**
     * 展示方式
     * @var array
     */
    protected $horizontal = true;
    /**
     * 验证规则
     * @var string
     */
    /**
     * 外层div元素classes.
     *
     * @var array
     */
    protected $outerOption = [
        'class' => ['col-xs-12', 'col-sm-4']
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
    protected $labelOption = [
        'class' => [
            'col-sm-2', 'col-xs-12','control-label'
        ]
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
    protected $elementOption = [
        'class'=>[
            'form-control'
        ]
    ];

    protected $labelName;

    public function init(Form $form)
    {
        $this->form = $form;

    }

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 字段
     * @param $column
     * @param string $value
     * @param array $option
     * @return $this
     */
    public function field($column, $value = '', $option = [])
    {
        $this->elementOption['name']  = "row[{$column}]";
        $this->elementOption['value'] = $value;
        $this->elementOption['id']    = 'c-' . $column;
        $this->labelOption['for']     = 'c-' . $column;
        if (!empty($option['class'])) {
            $this->elementOption['class'] = $option['class'];
            unset($option['class']);
        }
        $this->elementOption = array_merge($this->elementOption, $option);
        return $this;
    }

    public function render()
    {
        $Builder = new Builder($this);
        $method  = strtolower(str_replace("Future\\Admin\\Form\\Field\\", '', get_class($this)));
        $data    = $Builder->$method();

        $field   = '';
        foreach ($data as $key => $value) {
            if ($key == 'buttonName') {
                unset($data[$key]);
                continue;
            }
            if (is_array($value)) {
                foreach ($value as $key1 => $value1) {
                    $view = $this->view;
                    $view = str_replace("<%{$key}%>", $value1, $view);

                    if (!empty($data['buttonName'])) {
                        $view = str_replace("<%buttonName%>", isset($data['buttonName'][$key1])?$data['buttonName'][$key1]:'', $view);
                    }
                    $field .= $view . "\n";
                }
                unset($data[$key]);
            }
        }

        $data['field'] = $field;
        $default       = $this->defaultView;
        foreach ($data as $key => $value) {
            $default = str_replace("<%$key%>", $value, $default);
        }
        $this->form->form[] = $default;
        return $default;
    }

    /**
     *
     * @param $name
     * @param array $option
     * @return $this
     */
    public function label($name, $option = [])
    {
        $this->labelName = $name;
        if (!empty($option['class'])) {
            $this->labelOption['class'] = $option['class'];
            unset($option['class']);
        }
        $this->labelOption = array_merge($this->labelOption, $option);
        return $this;
    }

    /**
     * @param string $beforeHtml
     * @param string $afterHtml
     * @return $this
     */
    public function html($beforeHtml = '', $afterHtml = '')
    {
        $this->beforeHtml = $beforeHtml;
        $this->afterHtml  = $afterHtml;
        return $this;
    }

    /**
     * @param array $option
     * @return $this
     */
    public function rule($option = [])
    {
        $this->elementOption['data-rule'] = $option;
        return $this;
    }

    /**
     * @param $tip
     * @return $this
     */
    public function tip($tip)
    {
        $this->elementOption['data-tip'] = $tip;
        return $this;
    }

    /**
     * @param array $option
     * @return $this
     */
    public function outer($option = [])
    {
        if (!empty($option['class'])) {
            $this->outerOption['class'] = $option['class'];
            unset($option['class']);
        }
        $this->outerOption = array_merge($this->outerOption, $option);
        return $this;
    }

    /***
     * @param $method
     * @param $parameters
     * @return string
     */
    public function __call($method, $parameters)
    {
        preg_match('/^get(.*)/s', $method, $m);
        if (!empty($m[0]) && !empty($m[1])) {
            $param = lcfirst($m[1]);
            if (property_exists($this, $param)) {
                return $this->$param;
            } else {
                return false;
            }
        }
        if (empty($parameters)) {
            $method      = "Future\\Admin\\Form\\Field\\" . ucfirst($method);
            $method      = new $method($this->form);
            $this->model = $method;
            return $method;
        }

    }

}