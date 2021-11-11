<?php
    // 存储数据的文件
    $filename = './ani-text/data.txt';        
     
    if(!file_exists($filename)) {
        die($filename . ' 数据文件不存在');
    }
     
    // 读取整个数据文件
    $data = file_get_contents($filename);
     
    // 按换行符分割成数组
    $data = explode(PHP_EOL, $data);
     
    // 随机获取一行索引
    $result = $data[array_rand($data)];
     
    // 去除多余的换行符（保险起见）
    $result = str_replace(array("\r","\n","\r\n"), '', $result);

if(!$_GET["json"]){
    // 指定页面编码
    header('content-Type:text/plain; charset=utf-8');
    
    echo (htmlspecialchars($result)); 
   
}else {
    
    header("contentType:application/json; charset=utf-8");
    
    $origin_str = "{\"code\":200,\"text\":\"".htmlspecialchars($result)."\"}";
    //对原始字符串进行解码，转换为PHP对象或数组
    $json_obj = json_decode($origin_str);

    //对PHP对象或数组重新进行JSON编码，生成新的字符串
    //默认情况下，字符串中的中文会进行Unicode编码
    //多个配置参数之间，用竖线分隔
    $json_str = json_encode($json_obj, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
    echo($json_str);
}


?>