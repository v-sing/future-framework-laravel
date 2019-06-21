<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/5/17 0017
 * Time: 14:39
 */

namespace Future\Admin\Form\Field;


use Future\Admin\Form\Field;

class Checkbox extends Field
{
    protected $view = <<<EOF

EOF;

    public function __construct($form)
    {
        $this->form = $form;
    }

    public function data($data = [])
    {
        $this->data = !empty($data)?$data:[];
        return $this;
    }

    public function render()
    {
        $html = '';
        foreach ($this->data as $key => $value) {
            $checked = in_array($key, explode(',', $this->elementOption['value'])) ? "checked" : '';
            $tip     = lang(isset($this->elementOption['tip']) ? $this->elementOption['tip'] : '');
            $value   = lang($value);
            $html    .= "<label for=\"row[{$this->column}][]-{$key}\">
              <input id=\"row[{$this->column}][]-{$key}\"  name=\"row[{$this->column}[]\" type=\"checkbox\" value=\"{$key}\" data-tip=\"{$tip}\" {$checked} />{$value}
             </label>\n";
        }
        $this->view = $html;
        return parent::render(); // TODO: Change the autogenerated stub
    }

}