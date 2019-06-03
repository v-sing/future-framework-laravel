<?php
/**
 * Created by PhpStorm.
 * Author: 紫云沫雪こ
 * Email:email1946367301@163.com
 * Date: 2019/3/27 0027
 * Time: 15:18
 */

namespace App\Admin\Controllers;


use Future\Admin\Controllers\BackendController;

class DemoController extends BackendController
{
    public function database()
    {
        return $this->view();
    }

    public function logs()
    {
        $path  = 'F:\WORK\doc\check';
        $files = $this->loadRoutesFile($path);
        echo '现在不执行';
        exit;
        foreach ($files as $file) {
            $content  = trim(file_get_contents($file));
            $requests = explode("\r\n\r\n", $content);
            foreach ($requests as $key => $request) {
                $lines = explode("\r\n", $request);
                preg_match('/^\[(.*?)\]/', $lines[0], $ma);
                $requestInfo = explode(' ', trim(str_replace($ma[0], '', $lines[0])));
                if (!$requestInfo) {
                    dump($lines);
                    continue;
                }
                if (!isset($ma[1])) {
                    continue;
                }
                $ip              = $requestInfo[0];
                $url             = parse_url($requestInfo[1]);
                $url             = $url['path'];
                $requestTime     = strtotime(trim($ma[1]));
                $masterData      = [
                    'name'       => '',
                    'url'        => $url,
                    'created_at' => time()
                ];
                $LogsMasterArray = Model('LogsMaster')->where(['url' => $url])->first();
                if (!$LogsMasterArray) {
                    $model = Model('LogsMaster');
                    $model->data($masterData)->save();
                    $LogsMasterArray = $model;
                }
                $runAllTime = 0;
                $parentid   = $LogsMasterArray->id;
                $runData    = [
                    'parentid'   => $parentid,
                    'run_time'   => $runAllTime,
                    'ip'         => $ip,
                    'created_at' => $requestTime
                ];
                $model      = Model('LogsRun');
                $model->data($runData)->save();
                $sqlParent = $model->id;
                foreach ($lines as $key1 => $line) {
                    if (strpos($line, 'SQL:') !== false) {
                        preg_match('/\[(.*?)\]/', $line, $mas);
                        $runTime = trim(str_replace(['RunTime:', 's'], ['', ''], $mas[1]));
                        $sql     = trim(str_replace(['SQL:', $mas[0]], ['', ''], $line));
                        preg_match_all("/\'(.*?)\'/", $sql, $search);
                        $search_sql = $sql;
                        if (isset($search[0])) {
                            $search_sql = str_replace($search[0], $this->getEmpty($search[0]), $sql);
                        }
                        $sqlData = [
                            'parentid'   => $sqlParent,
                            'sql'        => $sql,
                            'search_sql' => $search_sql,
                            'run_time'   => $runTime
                        ];
                        $result  = Model('LogsSqls')->data($sqlData)->save();
                    }
                    if (strpos($line, 'RunTime:') !== false) {
                        preg_match('/\[(.*?)\]/', $line, $max);
                        $runAllTime = bcadd($runAllTime, trim(str_replace(['RunTime:', 's'], ['', ''], $max[1])), 7);
                    }
                }
                $model->run_time = $runAllTime;
                $model->save();
            }
        }

    }

    public function index()
    {
        return $this->view();
    }

    /**
     * 递归文件
     * @param $path
     * @return array
     */
    protected function loadRoutesFile($path)
    {
        $allRoutesFilePath = array();
        foreach (glob($path) as $file) {
            if (is_dir($file)) {
                $allRoutesFilePath = array_merge($allRoutesFilePath, $this->loadRoutesFile($file . '/*'));
            } else {
                $allRoutesFilePath[] = $file;
            }
        }
        return $allRoutesFilePath;
    }

    public function getEmpty($array)
    {
        $arr = [];
        foreach ($array as $v) {
            $arr[] = "''";
        }
        return $arr;
    }

    public function quchong()
    {
        '
        
[xhprof]

xhprof.output_dir="D:\laragon\tmp\xhprof\xhprof.log"';
        $array = Model('LogsMaster')->where('url', 'like', '%/zzkp.php/Home/Public/verify%')->whereNotIn('id', [17])->get()->toArray();
        $arr   = [];
        foreach ($array as $v) {
            $arr[] = $v['id'];
            $model = Model('LogsMaster');

        }
      echo  implode(',',$arr);
    }
}