<?php
/**
 * Created by IntelliJ IDEA.
 * BaseModel: LHC
 * Date: 2020/9/15
 * Time: 17:20
 */

namespace App\Helps;


use PhpOffice\PhpSpreadsheet\IOFactory;


/**
 * 成功返回
 *
 * @param $result
 *
 * @return \Illuminate\Http\JsonResponse
 */
function success($result)
{
    if ($result['code'] > 0) {
        return resJson($result['code'] ?? 1, $result['msg'] ?? "失败");
    } else {
        return resJson(0, $result['msg'] ?? "成功", $result['data']);
    }
}

/**
 * 文件下载返回
 *
 * @param $file
 *
 * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
 */
function successFile($file)
{
    return resJson(0, "成功", ['file'=>$file]);
}

/**
 * 统一数据返回
 *
 * @param int    $code
 * @param string $msg
 * @param array  $data
 * @param string $url
 *
 * @return \Illuminate\Http\JsonResponse
 */
function resJson($code = 0, $msg = '', $data = array(), $url = '')
{
    $out['code'] = $code ?: 0;
    $out['info'] = $msg;
    $out['data'] = $data ?: array();
    $out['url']  = $url;
    return response()->json($out);
}

/**
 * 系统内部返回数据
 *
 * @param string $msg
 * @param int    $code
 *
 * @return array
 */
function succ($data = [], $msg = '成功', $code = 0)
{
    return [ 'code' => $code, 'msg' => $msg, "data" => $data ];
}


/**
 * 系统内部返回数据
 *
 * @param string $msg
 * @param int    $code
 *
 * @return array
 */
function err($msg = '失败', $code = 500)
{
    if ($code == 500 && !config('conf.debug')) {
        $msg = "失败";
    }
    return [ 'code' => $code, 'msg' => $msg ];
}


/**
 * 密码加密
 */
function encryPass($pass)
{
    return \md5(sha1($pass).AUTH_KEY);
}

/**
 * 将Base64图片转换为本地图片并保存
 *
 * @param $base64_image_content
 * @param $path
 *
 * @return string
 */
function base64_image_content($base64_image_content, $path)
{
    $new_file = ROOT_PATH . $path;
    if (!file_exists($new_file)) {
        //检查是否有该文件夹，如果没有就创建，并给予最高权限
        mkdir($new_file, 0777, true);
    }

    $type = '.png';
    //匹配出图片的格式
    $name     = md5(uniqid(microtime(true), true)) . rand(100, 999);
    $new_file = $new_file . $name . $type;

    if (file_put_contents($new_file, base64_decode($base64_image_content))) {
        return $path . $name . $type;
    } else {
        return '';
    }
}


/**
 * 将图片转化为base64位图片
 *
 * @param $image
 *
 * @return string
 */
function image_base64_content($image)
{
    $new_file = ROOT_PATH . $image;
    if (file_exists($new_file)) {
        $content = file_get_contents($new_file);
        return chunk_split(base64_encode($content)); // base64编码
    }
    return '';
}


/**
 * 统一调用curl方法
 *
 * @param $url
 * @param $get_data
 *
 * @return bool|string
 */
function curlGet($url, $get_data)
{
    if ($get_data) {
        $url .= "?";
        foreach ($get_data as $key => $val) {
            $url .= $key . "=" . $val . '&';
        }
        $url = rtrim($url, '&');
    }
    //初始化
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // 执行后不直接打印出来
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    // 跳过证书检查
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // 不从证书中检查SSL加密算法是否存在
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    //执行并获取HTML文档内容
    $data = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $data;
}

/**
 * 统一调用curl方法(post)
 *
 * @param $url
 * @param $post_data
 *
 * @return bool|string
 */
function curlPost($url, $post_data)
{
    $curl    = curl_init();
    $headers = array(
        "Content-type: application/json;charset='utf-8'",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //设置抓取的url
    curl_setopt($curl, CURLOPT_URL, $url);
    //设置头文件的信息作为数据流输出
    curl_setopt($curl, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    //设置post方式提交
    curl_setopt($curl, CURLOPT_POST, 1);

    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    //执行命令
    $data = curl_exec($curl);
    //关闭URL请求
    curl_close($curl);
    return $data;
}

function exportExcel($fileName = '', $headArr = [], $data = [])
{
    $basePath = config('conf.comm.export');
    $path = ROOT_PATH.$basePath;
    if(!file_exists($path)){
        @mkdir($path, 0777, true);
    }
    $objPHPExcel = new \PHPExcel();
    $objPHPExcel->getProperties();
    $key = ord("A"); // 设置表头
    foreach ($headArr as $v) {
        $col = chr($key);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col . '1', $v);
        $key += 1;
    }
    $column      = 2;
    $objActSheet = $objPHPExcel->getActiveSheet();
    foreach ($data as $key => $rows) { // 行写入
        $span = ord("A");
        foreach ($rows as $keyName => $value) { // 列写入
            if ($keyName == 'idCode') {
                $objActSheet->setCellValueExplicit(chr($span) . $column, $value, \PHPExcel_Cell_DataType::TYPE_STRING);
            } else {
                $objActSheet->setCellValue(chr($span) . $column, $value);
            }
            $span++;
        }
        $column++;
    }
    $objPHPExcel->setActiveSheetIndex(0); // 设置活动单指数到第一个表,所以Excel打开这是第一个表
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save($path.$fileName);
    return $basePath.$fileName;
}

/**
 * 获取文件导入信息
 * @param string $file
 * @param bool $needImage  是否包含图片
 * @param string $image  图片位置
 * @return array
 */
function importExcel($file = '', $needImage = false,$image='')
{
    try {
        $ext    = ucfirst(pathinfo($file, PATHINFO_EXTENSION));
        $reader = IOFactory::createReader($ext);
        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($file);
        $worksheet   = $spreadsheet->getActiveSheet();
        $data = [];
        foreach ($worksheet->getRowIterator() as $key => $row) {
            if ($key === 1) {
                continue;
            }
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);
            $arr =[];
            foreach ($cellIterator as $k => $cell) {
                if($k === $image){
                    continue ;
                }
                $cellValue = $cell->getValue();
                $cellValue = str_replace([ PHP_EOL, '\r\n', '\r', ' ' ], '', $cellValue);
                $arr[] = $cellValue;
            }
            $data[$key] = $arr;
        }

        // 处理头像
        if ($needImage&&$image) {
            $spreadsheet = IOFactory::load($file);
            $secondPath         = ROOT_PATH.config('conf.comm.user');
            if (!file_exists($secondPath)) {
                @mkdir($secondPath, 0777, true);
            }
            foreach ($spreadsheet->getActiveSheet()->getDrawingCollection() as $drawing) {
                if ($drawing instanceof \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing) {
                    ob_start();
                    call_user_func(
                        $drawing->getRenderingFunction(),
                        $drawing->getImageResource()
                    );
                    $imageContents = ob_get_contents();
                    ob_end_clean();
                    switch ($drawing->getMimeType()) {
                        case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_PNG :
                            $extension = 'png';
                            break;
                        case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_GIF:
                            $extension = 'gif';
                            break;
                        case \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_JPEG :
                            $extension = 'jpg';
                            break;
                    }
                } else {
                    $zipReader     = fopen($drawing->getPath(), 'r');
                    $imageContents = '';
                    while (!feof($zipReader)) {
                        $imageContents .= fread($zipReader, 1024);
                    }
                    fclose($zipReader);
                    $extension = $drawing->getExtension();
                }
                $guid                          = create_guid();
                $myFileName                    = $secondPath . $guid . '.' . $extension;
                $imgIndex                      = ltrim($drawing->getCoordinates(), $image);
                $data[$imgIndex]['avatar_url'] = $secondPath . $guid . '.' . $extension;
                file_put_contents($myFileName, $imageContents);
            }
        }
        return $data;
    } catch (\Exception $exception) {
        return [];
    }
}

function create_guid($namespace = '')
{
    static $guid = '';
    $uid = uniqid("", true);
    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
    return $hash;
}