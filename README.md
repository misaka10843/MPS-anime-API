# MPS-anime-API
喵帕斯动画网站的开源API项目

---

# 喵帕斯动画API

### 1.随机动漫壁纸API

**1.直接访问**

您可以直接访问 [此链接](http://action.sakurakoyi.top:10010/api/acg.php "点击即可访问") 即可获取图片(直接返回图片)

链接: `http://action.sakurakoyi.top:10010/api/acg.php`

返回(图片已缩小)：

<img width="30%" src="http://action.sakurakoyi.top:10010/api/acg.php">


**2.通过json访问**

请求方式：

`GET  http://action.sakurakoyi.top:10010/api/acg.php?json=1`

返回数据：

```bash
请求：
http://action.sakurakoyi.top:10010/api/acg.php?json=1
返回：
{ "code": 200, "url": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/随机图片\/47.jpg" }
```

**3.附加参数**

此API可以附加 `folder/num/picnum`参数

**1.其中，如果您想指定哪个文件夹图片，您可以使用以下 `folder`参数**

| 参数     | 表示                       |
| -------- | -------------------------- |
| misaka   | misaka10843的pixiv收藏     |
| qwq      | 我永远喜欢空银子的收集图片 |
| qwq2.0   | 我永远喜欢空银子的收集图片 |
| 随机图片 | 浅笙-梦羽的收集图片        |

**`folder`参数使用说明**
普通访问：
`http://action.sakurakoyi.top:10010/api/acg.php?folder={参数}`

json访问：
`http://action.sakurakoyi.top:10010/api/acg.php?folder={参数}&json=1`

例如：
`http://action.sakurakoyi.top:10010/api/acg.php?folder=misaka`即可访问 `misaka10843的pixiv收藏`

返回(图片已缩小)：

<img width="30%" src="http://action.sakurakoyi.top:10010/api/acg.php?folder=misaka">


**2.其中，您想输出多个图片，您可以这样使用 `num`参数**

取 `1-50`之间的自然数填入 `num参数`即可

注意！此参数**必须**要通过**json访问**才可以运行！

**`num`参数使用说明**

json访问：

`http://action.sakurakoyi.top:10010/api/acg.php?num={1-50之间的自然数}&json=1`

例如：

`http://action.sakurakoyi.top:10010/api/acg.php?num=10&json=1`

返回：

```json
{
    "code": 200,
    "url": [
        {
            "0": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/qwq\/7e4b2cbe57f940336863762e29d6bdbc.jpeg",
            "1": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/qwq2.0\/005838cc977c8b8e09d6c4361fae7b3f.jpeg",
            "2": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/misaka\/びっくりしいなん_0_84848893.png",
            "3": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/misaka\/Manjaro-chan (Dark／Light／PNG)_6_91376951.png",
            "4": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/misaka\/たまちゃん！！！！！_0_83995646.jpg",
            "5": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/misaka\/Koi Studies_0_82663838.jpg",
            "6": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/随机图片\/136.jpg",
            "7": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/misaka\/バニーチノちゃん_0_63376936.jpg",
            "8": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/misaka\/▲_0_72579396.jpg",
            "9": "http:\/\/action.sakurakoyi.top:10010\/api\/acgimg\/misaka\/すべりこみシリーズ かおす先生_0_68863041.jpg"
        }
    ]
}
```

**3.其中，您想获取API中图片数量，您可以这样使用 `picnum`参数**

直接访问[此链接](http://action.sakurakoyi.top:10010/api/acg.php?picnum=1 "点击即可访问")即可~
`http://action.sakurakoyi.top:10010/api/acg.php?picnum=1`

注意！此参数**必须**只能严格按照**上面链接**访问才可以运行！

**`picnum`参数使用说明**

普通访问：
`http://action.sakurakoyi.top:10010/api/acg.php?picnum=1`
返回：
`现有图片数量：738`

### 2.动漫语录API

**1.直接访问**

您可以直接访问 [此链接](http://action.sakurakoyi.top:10010/api/ani-text.php) 即可获取文本(直接返回文本)

链接:`http://action.sakurakoyi.top:10010/api/ani-text.php`

**2.通过json访问**

请求方式:

`GET  http://action.sakurakoyi.top:10010/api/ani-text.php?json=1`

返回数据：

```bash
请求：
http://action.sakurakoyi.top:10010/api/ani-text.php?json=1
返回：
{ "code": 200, "text": "[文本]" }
```

### 3.bilibili av号转cid

**1.通过json访问**

请求方式：

`GET  http://action.sakurakoyi.top:10010/bilibili.php?aid={av号}`

返回数据：

```bash
请求:
http://action.sakurakoyi.top:10010/bilibili.php?aid=314
返回:
{"cid":"3262388"}
```

### 4.coruseforge加速节点

**1.直接访问**

链接：

`http://action.sakurakoyi.top:10010/api/CurseForge`

**注意！因为著名的跨域问题，您似乎并不能在加速器的情况下打开此页面！**

截图：

<img width="30%" src="http://anime.sakurakoyi.top:10843/usr/uploads/2021/11/679516595.png">

### 5.TokyoMX当日节目表API

此API是获取日本电视台-TokyoMX1台的当日节目表(其中[喵帕斯动画的TokyoMX直播](http://anime.sakurakoyi.top:10843/anime/id-276/bangumi.anime?action=get&p=3)的节目单就是使用的此API)

**1.直接访问**

链接：

`http://action.sakurakoyi.top:10010/api/tokyoMX`

**2.json访问**

请求方式：

`GET  http://action.sakurakoyi.top:10010/api/tokyoMX?json=1`

返回数据：

```bash
[
{ "Event_id": "0xdbe2", "Start_time": "2021年11月21日05時00分00秒", "Duration": "00:30:00", "Event_name": "お買い物情報", "Event_text": " ", "Component": "1080i 16:9 パンベクトルなし", "Sound": "ステレオ", "Event_detail": ""},
......
{ "Event_id": "0x0001", "Start_time": "2021年11月22日02時35分00秒", "Duration": "02:25:00", "Event_name": "放送休止中", "Event_text": "", "Component": "", "Sound": "", "Event_detail": ""}
]
```

### 6.json跨域支持API

此API是将一些无法跨域使用的json通过API实现跨域请求
（不是返回jsonp，而是json）

**1.直接访问**

链接：

`http://action.sakurakoyi.top:10010/api/json?url={链接}`


```bash
{您需要跨域的json的内容}
```

---

**更多API正在适配中**
