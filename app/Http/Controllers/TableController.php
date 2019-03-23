<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/22 0022
 * Time: 12:40
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    protected $function = '';
    protected $drop = '';

    public function index()
    {
        exit;
        $this->function .= '$connection = config(\'admin.database.connection\') ?: config(\'database.default\');' . "\r\n";

        $data = config('admin.database');

        foreach ($data as $v) {
            $this->table($v);
            $this->drop .= 'Schema::connection($connection)->dropIfExists(config(\'admin.database.' . $v . '\'));' . "\r\n";
        }
        echo $this->drop;
        exit;
    }

    public function getTableArray()
    {
      exit;
        $data  = config('admin.database');
        $array = [];
        foreach ($data as $v) {
            $list = DB::table($v)->get()->FutureToArray();
            if ($list) {
                $array[$v] = $list;
            }
        }
       $file= __DIR__ . '/sql.php';
        $text='<?php   return '.var_export($array,true).';';
        if(false!==fopen($file,'w+')){
            file_put_contents($file,$text);
        }else{
            echo '创建失败';
        }
    }

    public function table($table)
    {
        $this->function .= 'Schema::connection($connection)->create(config(\'admin.database.' . $table . '\'), function (Blueprint $table) {';
        $this->function .= $this->column(DB::select("SELECT column_name,column_type,IS_NULLABLE,column_key,COLUMN_COMMENT,COLUMN_DEFAULT FROM information_schema.columns WHERE table_schema= 'zlt_laravel' AND table_name = 'fa_{$table}'"));
        $this->function .= "\r\n" . '});' . "\r\n";
    }

    public function column($column)
    {
// dd($column);
        $table = '';
        foreach ($column as $v) {
            $table .= "\r\n" . '$table';
            preg_match('/\d+/', $v->column_type, $ma);
            $lenth = isset($ma[0]) ? $ma[0] : 20;
            if (strpos($v->column_type, 'int') !== false) {
                if ($v->column_key == 'PRI') {
                    $table .= '->bigIncrements(\'' . $v->column_name . '\')';
                } else {
                    $table .= '->integer(\'' . $v->column_name . '\',' . $lenth . ')';
                }
            } elseif (strpos($v->column_type, 'text') !== false) {
                $table .= '->text(\'' . $v->column_name . '\')';
            } elseif (strpos($v->column_type, 'varchar') !== false) {
                $table .= '->string(\'' . $v->column_name . '\',' . $lenth . ')';
            } elseif (strpos($v->column_type, 'decimal') !== false) {
                $table .= '->decimal(\'' . $v->column_name . '\',10,2)';
            } elseif (strpos($v->column_type, 'enum') !== false && $v->column_name == '') {
                $table .= '->enum(\'' . $v->column_name . '\',[\'menu\',\'file\'])';
            } else {
                $table .= '->string(\'' . $v->column_name . '\',' . $lenth . ')';
            }
            $table .= '->comment(\'' . $v->COLUMN_COMMENT . '\');' . "\r\n";

        }
        $table .= '$table->timestamps();' . "\r\n";
        return $table;
    }
}