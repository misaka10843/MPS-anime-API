<?php
function vget($url)
{
    
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  $data = curl_exec($curl);
  if (curl_errno($curl)) {return 'ERROR '.curl_error($curl);}
  curl_close($curl);
   return $data ;
}   


$url = "https://s.mxtv.jp/bangumi_file/json01/SV1EPG".date('Y').date('m').date('d').".json";
if($_GET["json"] == "1"){
header("Location: {$url}");
exit();
}
?>
<table border="1">
  <tr>
    <th>时间</th>
    <th>节目</th>
  </tr>
<?php
$json=vget($url);
 $obj=json_decode($json);

  $i=0;
   foreach ( $obj as $unit )
   {
       $i++;
       $arr[$i]['Start_time']=$unit->Start_time;
       $arr[$i]['Event_name']=$unit->Event_name;
       echo("<tr>
                <td>{$arr[$i]['Start_time']}</td>
                <td>{$arr[$i]['Event_name']}</td>
            </tr>");

  }
?>
</table>
