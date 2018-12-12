# tp5tool
收集PHP常用的工具类,一个代码搬运工.

## 安装

> composer require "xiucaiwu/tp5tool:dev-master"

## 删除

> composer remove xiucaiwu/tp5tool

## 更新

> composer update xiucaiwu/tp5tool

## 使用

SelectTree使用场景=>后台管理系统的菜单列表
![菜单列表](https://github.com/xiucaiwu/tp5tool/blob/master/screenshots/20180516133315.png)

```
//引入类库
use PHPTool\SelectTree;

// SelectTree 使用案例
public function stdemo()
{
    $arr = array(
             1  => array('id' =>'1','parentid' =>0,'name' =>'一级栏目一'),
             2  => array('id' =>'2','parentid' =>0,'name' =>'一级栏目二'),
             3  => array('id' =>'3','parentid' =>1,'name' =>'二级栏目一'),
             4  => array('id' =>'4','parentid' =>1,'name' =>'二级栏目二'),
             5  => array('id' =>'5','parentid' =>2,'name' =>'二级栏目三'),
             6  => array('id' =>'6','parentid' =>3,'name' =>'三级栏目一'),
             7  => array('id' =>'7','parentid' =>3,'name' =>'三级栏目二')
        );
        $st = new SelectTree($arr);
        dump($st->getArray());
        // 下拉菜单选项使用 get_tree方法
        $html='<select name="tree">';
        $str = "<option value=\$id \$selected>\$spacer\$name</option>";     // $name是数组中存在的key
        $html .= $st->get_tree(0, $str, -1).'</select>';
        echo $html;
}
```

// 输出

```
array(7) {
  [1] => array(3) {
    ["id"] => string(1) "1"
    ["parentid"] => int(0)
    ["name"] => string(16) " 一级栏目一"
  }
  [3] => array(3) {
    ["id"] => string(1) "3"
    ["parentid"] => int(1)
    ["name"] => string(46) "&nbsp;&nbsp;&nbsp;&nbsp;├─ 二级栏目一"
  }
  [6] => array(3) {
    ["id"] => string(1) "6"
    ["parentid"] => int(3)
    ["name"] => string(73) "&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp;├─ 三级栏目一"
  }
  [7] => array(3) {
    ["id"] => string(1) "7"
    ["parentid"] => int(3)
    ["name"] => string(74) "&nbsp;&nbsp;&nbsp;&nbsp;│&nbsp;&nbsp;&nbsp;&nbsp; └─ 三级栏目二"
  }
  [4] => array(3) {
    ["id"] => string(1) "4"
    ["parentid"] => int(1)
    ["name"] => string(47) "&nbsp;&nbsp;&nbsp;&nbsp; └─ 二级栏目二"
  }
  [2] => array(3) {
    ["id"] => string(1) "2"
    ["parentid"] => int(0)
    ["name"] => string(16) " 一级栏目二"
  }
  [5] => array(3) {
    ["id"] => string(1) "5"
    ["parentid"] => int(2)
    ["name"] => string(47) "&nbsp;&nbsp;&nbsp;&nbsp; └─ 二级栏目三"
  }
}
<select name="tree">
<option value=1 >一级栏目一</option>
<option value=3 >&nbsp;├─二级栏目一</option>
<option value=6 >&nbsp;│&nbsp;├─三级栏目一</option>
<option value=7 >&nbsp;│&nbsp; └─三级栏目二</option>
<option value=4 >&nbsp; └─二级栏目二</option>
<option value=2 >一级栏目二</option>
<option value=5 >&nbsp; └─二级栏目三</option>
</select>
```

NodeTree使用场景=>后台管理系统的控制菜单
![控制菜单](https://github.com/xiucaiwu/tp5tool/blob/master/screenshots/20180516133410.png)

```
//引入类库
use PHPTool\NodeTree;

// NodeTree使用案例
public function ntdemo() {
	//原始数据, 从数据库读出
	$data = array(
		array(
			'id'=>1,
			'name'=>'book',
			'parent_id'=>0
		),
		array(
			'id'=>2,
			'name'=>'music',
			'parent_id'=>0
		),
		array(
			'id'=>3,
			'name'=>'book1',
			'parent_id'=>1
		),
		array(
			'id'=>4,
			'name'=>'book2',
			'parent_id'=>3
		)
	);
	$r = NodeTree::makeTree($data);
	echo json_encode($r);
}
```

// 输出

```
[{
	"id": 1,
	"name": "book",
	"parent_id": 0,
	"expanded": false,
	"children": [{
		"id": 3,
		"name": "book1",
		"parent_id": 1,
		"expanded": false,
		"children": [{
			"id": 4,
			"name": "book2",
			"parent_id": 3,
			"leaf": true
		}]
	}]
}, {
	"id": 2,
	"name": "music",
	"parent_id": 0,
	"leaf": true
}]
```
Curl使用场景

```
//引入类库
use PHPTool\Curl;

// Curl get使用案例
public function get() {
	echo Curl::get('www.baidu.com');
}

// Curl post使用案例
public function post() {
	$field = [
		'p'		=> 1,
		'time'	=> time(),
	];
	$userAgent = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36';
	$httpHeaders = [
		"Content-type: application/json;charset='utf-8'",
　　	"Accept: application/json",
　　	"Cache-Control: no-cache",
　　	"Pragma: no-cache",
	];
	
	echo Curl::post('http://www.ahlinux.com/', $field, $userAgent, $httpHeaders);
}
```