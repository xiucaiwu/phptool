# tp5tool
收集PHP常用的工具类,一个代码搬用工.

## 安装

> composer require "xiucaiwu/tp5tool:dev-master"

## 删除

> composer remove xiucaiwu/tp5tool

## 更新

> composer update xiucaiwu/tp5tool

## 使用

```
//引入类库
use PHPTool\SelectTree;
```
```
//SelectTree 使用案例
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
        var_dump($st->getArray());
        // 下拉菜单选项使用 get_tree方法
        $html='<select name="tree">';
        $str = "<option value=\$id \$selected>\$spacer\$name</option>";     // $name是数组中存在的key
        $html .= $st->get_tree(0, $str, -1).'</select>';
        echo $html;
}
```
