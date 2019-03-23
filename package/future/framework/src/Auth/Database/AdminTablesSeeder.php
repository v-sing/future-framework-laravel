<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/22 0022
 * Time: 14:24
 */

namespace Future\Admin\Auth\Database;

use Illuminate\Database\Seeder;


class AdminTablesSeeder extends Seeder
{
    public function run()
    {
        $dataArray = require dirname(dirname(dirname(__DIR__))) . '/database/tableData/data.php';
        foreach ($dataArray as $table=>$data){
            $model=config('admin.database.'.$table.'_model');
            $model::truncate();
            $model::insert($data);
        }
    }
}