<?php
//* 文件数量获取
function ShuLiang($url)//造一个方法，给一个参数
{
    $sl=0;
    $arr = glob($url);//把该路径下所有的文件存到一个数组里面;
    foreach ($arr as $v){
        if(is_file($v)){
            $sl++;//如果是文件，数量加一;
        }else{
            $sl+=ShuLiang($v."/*");//如果是文件夹，那么再调用函数本身获取此文件夹下文件的数量;
        }
    }
    return $sl;//返回值$sl
}

//* 输出文件数量
if($_GET["picnum"] == 1){
header('content-Type:text/plain; charset=utf-8');
echo "现有图片数量：".ShuLiang("./acgimg/*");//用这个方法查一下该路径下所有的文件数量;
exit();
}

//* 判断是否定向文件夹定义路径
if(!$_GET["folder"] || $_GET["folder"] == 0){
	//这将得到一个文件夹中的所有gif，jpg和png图片的数组 
	$imgpath = "acgimg/*/*.{gif,jpg,png,jpeg}";
}else{
	//这将得到一个文件夹中的所有gif，jpg和png图片的数组 
	$imgpath = "acgimg/".$_GET["folder"]."/*.{gif,jpg,png,jpeg}";
}

//* 如果只是需要输出图片
if(!$_GET["json"] || $_GET["json"] == 0 && !$_GET["num"]){
    //这将得到一个文件夹中的所有gif，jpg和png图片的数组 
	$img_array = glob($imgpath,GLOB_BRACE);
	//从数组中选择一个随机图片 
	$img = array_rand($img_array);
	header("Content-type: image/png");
	$im = @imagecreatefromjpeg("$img_array[$img]");
	imagejpeg($im);
  exit();
}elseif( $_GET["json"] == 0 && $_GET["num"]){
  echo("请求错误");
  exit();
}

//* 如果需要输出json
if($_GET["json"] == 1){
  //* 判断是否需要输出多个图片
	if($_GET["num"] > 0 && $_GET["num"] <= 50){
		$origin_str = "{\"code\":200,\"url\":[{";
		for ($i = 0; $i < $_GET["num"]; $i++){
        	//这将得到一个文件夹中的所有gif，jpg和png图片的数组 
        	$img_array = glob($imgpath,GLOB_BRACE);
        	//从数组中选择一个随机图片 
        	$img = array_rand($img_array);
          //* 组成图片链接
        	$imgurl = 'http://'. $_SERVER['HTTP_HOST'] . '/api/' . $img_array[$img];
			if($i == $_GET["num"] - 1){
				$json = "\"$i\":\"$imgurl\"}]}";
			}else{
				$json = "\"$i\":\"$imgurl\",";
			}
			$origin_str =  $origin_str . $json;
		}
	}elseif(!$_GET["num"]){
    //*只输出一张图片
	  //这将得到一个文件夹中的所有gif，jpg和png图片的数组 
    $img_array = glob($imgpath,GLOB_BRACE);
    //从数组中选择一个随机图片 
    $img = array_rand($img_array);
	  //组成图片链接
		$imgurl = 'http://'. $_SERVER['HTTP_HOST'] . '/api/' . $img_array[$img];
		$origin_str = "{\"code\":200,\"url\":\"$imgurl\"}";
	}else{
    $origin_str = "{\"code\":403,\"url\":\"请求错误\"}";
  }
	header("contentType:application/json; charset=utf-8");
	//对原始字符串进行解码，转换为PHP对象或数组
	$json_obj = json_decode($origin_str);
	//对PHP对象或数组重新进行JSON编码，生成新的字符串
	//默认情况下，字符串中的中文会进行Unicode编码
	//多个配置参数之间，用竖线分隔
	$json_str = json_encode($json_obj, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
	//格式化输出
	echo '<pre>';
  echo $json_str;
  echo '</pre>';
}
?>