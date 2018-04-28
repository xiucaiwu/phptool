<?php
/**
+------------------------------------------------
 * 通用的树型类[增强版,可以定义父类id的名字]
+------------------------------------------------
 * @author xiucai
 * @author yangyunzhou@foxmail.com(原作者)
+------------------------------------------------
 * @date 2018年03月18日
+------------------------------------------------
 */
namespace PHPTool;


class SelectTree
{

    /**
    +------------------------------------------------
     * 生成树型结构所需要的2维数组
    +------------------------------------------------
     * @author yangyunzhou@foxmail.com
    +------------------------------------------------
     * @var Array
     */
    public $arr = array();

    /**
    +------------------------------------------------
     * 生成树型结构所需修饰符号，可以换成图片
    +------------------------------------------------
     * @author yangyunzhou@foxmail.com
    +------------------------------------------------
     * @var Array
     */
    public $icon = array('│','├─',' └─');

    /**
     * @access private
     */
    public $ret = '';
    public $arrTree = array();
    public $option = array(
        /* 主键 */
        'primary_key'   => 'id',
        /* 菜单 */
        'menu_name'     => 'name',
        /* 父键 */
        'parent_key'    => 'parentid'
    );
    /**
     * 构造函数，初始化类
     * @param array 2维数组，例如：
     * array(
     *      1  => array('id' =>'1','parentid' =>0,'name' =>'一级栏目一'),
     *      2  => array('id' =>'2','parentid' =>0,'name' =>'一级栏目二'),
     *      3  => array('id' =>'3','parentid' =>1,'name' =>'二级栏目一'),
     *      4  => array('id' =>'4','parentid' =>1,'name' =>'二级栏目二'),
     *      5  => array('id' =>'5','parentid' =>2,'name' =>'二级栏目三'),
     *      6  => array('id' =>'6','parentid' =>3,'name' =>'三级栏目一'),
     *      7  => array('id' =>'7','parentid' =>3,'name' =>'三级栏目二')
     *      )
     */
    function __construct($arr = array(), $option = array())
    {
        $this->option = array_merge($this->option, $option);
        $this->arr =  $arr;
    }

    /**
     * 得到父级数组
     * @param int
     * @return array
     */
    function get_parent($myid)
    {
        $newarr = array();
        if(!isset($this->arr[$myid])) return false;
        extract($this->option);
        $pid = $this->arr[$myid][$parent_key];
        $pid = $this->arr[$pid][$parent_key];
        if(is_array($this->arr))
        {
            foreach($this->arr as $id => $a)
            {
                if($a[$parent_key]  == $pid) $newarr[$id]  = $a;
            }
        }
        return $newarr;
    }

    /**
     * 得到子级数组
     * @param int
     * @return array
     */
    function get_child($myid)
    {
        extract($this->option);
        $newarr = array();

        if(is_array($this->arr) || is_object($this->arr))
        {
            foreach($this->arr as $id => $a)
            {
                if($a[$parent_key] == $myid) $newarr[$id] = $a;
            }
        }
        return $newarr ? $newarr : false;
    }

    /**
     * 得到当前位置数组
     * @param int
     * @return array
     */
    function get_pos($myid,&$newarr)
    {
        $a = array();
        if(!isset($this->arr[$myid])) return false;
        extract($this->option);
        $newarr[]  = $this->arr[$myid];
        $pid  = $this->arr[$myid][$parent_key];
        if(isset($this->arr[$pid]))
        {
            $this->get_pos($pid,$newarr);
        }
        if(is_array($newarr))
        {
            krsort($newarr);
            foreach($newarr as $v)
            {
                $a[$v['id']]  = $v;
            }
        }
        return $a;
    }

    /**
     * -------------------------------------
     *  得到树型结构
     * -------------------------------------
     * @author yangyunzhou@foxmail.com
     * @param $myid 表示获得这个ID下的所有子级
     * @param $str 生成树形结构基本代码, 例如: "<option value =\$id \$selected>\$spacer\$name</option>"
     * @param $sid 被选中的ID, 比如在做树形下拉框的时候需要用到
     * @param $adds
     * @param $str_group
     */
    function get_tree($myid, $str, $sid = 0, $adds = '', $str_group = '')
    {
        $number  = 1;
        extract($this->option);
        $child  = $this->get_child($myid);
        if(is_array($child)) {
            $total = count($child);
            foreach($child as $id =>$a) {
                $j = $k = '';
                if($number == $total) {
                    $j .= $this->icon[2];
                } else{
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';
                $selected = $id == $sid ? 'selected' : '';
                @extract($a);
                $$parent_key == 0 && $str_group ? eval("\$nstr  = \"$str_group\";") : eval("\$nstr  = \"$str\";");
                $this->ret .= $nstr;
                $this->get_tree($id, $str, $sid, $adds.$k.'&nbsp;',$str_group);
                $number++;
            }
        }
        return $this->ret;
    }

    /**
     * 同上一方法类似,但允许多选
     */
    function get_tree_multi($myid, $str, $sid = 0, $adds = '')
    {
        $number = 1;
        $child = $this->get_child($myid);
        if(is_array($child))
        {
            $total = count($child);
            foreach($child as $id =>$a)
            {
                $j = $k = '';
                if($number == $total)
                {
                    $j .= $this->icon[2];
                }
                else
                {
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer  = $adds ? $adds . $j : '';
                $selected  = $this->have($sid,$id) ? 'selected': '';
                @extract($a);
                eval("\$nstr  = \"$str\";");
                $this->ret .= $nstr;
                $this->get_tree_multi($id, $str, $sid, $adds.$k.'&nbsp;');
                $number++;
            }
        }
        return $this->ret;
    }

    function have($list,$item){
        return (strpos(',,'.$list.',',','.$item.','));
    }

    /**
    +------------------------------------------------
     * 格式化数组
    +------------------------------------------------
     * @author yangyunzhou@foxmail.com
    +------------------------------------------------
     */
    function getArray($myid = 0, $sid = 0, $fill='&nbsp;', $adds = '')
    {
        $number = 1;
        $child = $this->get_child($myid);
        extract($this->option);
        if(is_array($child)) {
            $total = count($child);
            foreach($child as $id => $a) {
                $j = $k = '';
                if($number == $total) {
                    $j .= $this->icon[2];
                } else{
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds . $j : '';
                @extract($a);
                $a[$menu_name] = $spacer . ' ' . $a[$menu_name];
                $this->arrTree[$a['id']] = $a;
                $fill_rep = str_repeat($fill, 4);
                $fd = $adds . $k . $fill_rep;
                $this->getArray($id, $sid, $fill, $fd);
                $number++;
            }
        }
        return $this->arrTree;
    }
}