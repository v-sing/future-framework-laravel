<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/5/7 0007
 * Time: 10:30
 */

namespace Future\Admin\Form\Field;

use Future\Admin\Form\Builder;
use Future\Admin\Form\Field;

/**
 * 按钮
 * Class Button
 */
class Button extends Field
{
    protected $name = [];
    /**
     * 默认class
     * @var string
     */
    protected $class = '';
    /**
     * 按钮类型
     * @var string
     */
    protected $type = [];
    /**
     * 按钮模板
     * @var string
     */
    protected $buttonModel = <<<EOF
     <button type="<%type%>" class="btn " <%elementAttribute%>><%name%></button>
EOF;

    public function __construct($form)
    {
        $this->form = $form;
    }

    public function submit($name, $option = [])
    {
        if (empty($option['class'])) {
            $option['class'] = [
                'btn-success',
                'btn-embossed'
            ];
        }
        $this->type[]   = 'submit';
        $this->name[]   = $name;
        $this->elementOption[] = $option;
        return $this;
    }

    public function reset($name, $option = [])
    {
        if (empty($option['class'])) {
            $option['class'] = [
                'btn-default',
                'btn-embossed'
            ];
        }
        $this->type[]   = 'reset';
        $this->name []  = $name;
        $this->elementOption[] = $option;
        return $this;
    }

    /**
     * 属性
     * @param $type
     * @param $name
     * @param array $option
     * @return $this
     */
    public function addButton($name, $option = ['class' => 'btn-primary'])
    {
        $this->type[]   = 'button';
        $this->name[]   = $name;
        $this->elementOption[] = $option;
        return $this;
    }

    public function render()
    {

        $this->form->form[] = $this;
        $Builder   = new Builder($this);
        $Builder->button();
    }

}