<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/24
 * Time: 17:01
 */

namespace Future\Admin\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use Illuminate\Validation\Validator;

trait Backend
{
    /**
     * Get a validation factory instance.
     *
     * @return \Illuminate\Contracts\Validation\Factory
     */
    protected function getValidationFactory()
    {
        return app(Factory::class);
    }

    /**
     * 验证重写
     * @param Request $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return mixed
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {

        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);
        if ($validator->fails()) {
            foreach ($this->formatValidationErrors($validator) as $k => $v) {
                foreach ($v as $v1) {
                    return $v1;
                }
            }
        }
    }

    /**
     * Format the validation errors to be returned.
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return array
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator->errors()->getMessages();
    }

}