<?php

namespace Zxg321\Zmall\Database;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Zxg321\Zmall\Database\NetContent;
class NetMenu extends Model
{
    use ModelTree, AdminBuilder;
    public static $codes=['link'=>'连接','news'=>'新闻','newsindex'=>'－新闻首页','newslist'=>'－新闻列表','content'=>'内容显示','guestbook'=>'你问我答'];
    public static $audit_type=['1' => '仅一个审核员通过', '2'=> '必须所有审核员通过','3'=>'使用设定审核流程'];
    public static $audit_type1=['1' => '仅一个审核员通过', '2'=> '必须所有审核员通过'];
    
    //protected $table = 'zmall_net_menu';
    //protected $primaryKey='cate_id';
    //public $timestamps = false;//时间戳关闭 created_at 和 updated_at 字段
    //public $guarded = ['sort_order'];//黑名单属性
    protected $casts = [
        'audit_list' => 'array',
    ];
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('zmall.db_prefix','zmall_').'net_menu');
        parent::__construct($attributes);

        //$this->setParentColumn('parent_id');
        $this->setOrderColumn('sort_order');
        //$this->setTitleColumn('cate_name');
    }
    public function content()
    {
        return $this->hasOne(NetContent::class);
    }
    //导航条
    public static function getNavbar($item){
        if(is_null($item))return;
        if($item->parent_id==0){//当前是次高级了
            echo '<a href="/">首页</a>';
            echo ' > <a href="'.NetCategory::setURL($item).'">'.$item->title.'</a>';
        }else{
            if($pmenu=NetCategory::find($item->parent_id)){
                NetCategory::getNavbar($pmenu);
                echo ' > <a href="'.NetCategory::setURL($item).'">'.$item->title.'</a>';
            }
            
        }

    }
    //返回左侧菜单项目
    public static function getMenu($item){
        $re['parent']=$item;$re['menu']=[];
        $menu=NetCategory::where([['parent_id',$item->id],['st',1]])->get();
        if( count($menu)>0){//有下一级直接返回下一级
            $re['menu']=$menu;
        }else{
            if($item->parent_id!=0){
                $re['parent']=NetCategory::find($item->parent_id);
                $menu=NetCategory::where([['parent_id',$item->parent_id],['st',1]])->get();
                $re['menu']=$menu;
            }
        }
        return $re;
    }
    public static function setURL($item){
        if($item->code=='link')$url=$item->url;
        else $url='/category?id='.$item->id;
        return $url;
    }
    public static function getCateList($id=0,$num=6){
        $myMenu=NetCategory::where('parent_id',$id)->where('st',1)->orderBy('sort_order', 'asc')->get();
        $menu='';$item='';
        foreach ($myMenu as $key => $value) {
            $is_long='';
            if(mb_strlen($value->title)>5){$is_long=' class="hgjj_btts"';}
            if(mb_strlen($value->title)>8){$value->title=str_limit($value->title,8,'...');}
            $menu.="<li><a href=\"/category?id=".$value->id."\"$is_long>".$value->title."</a></li>";
            $item.='<div class="con"><ul>';
            $myItem=NetContent::where('category_id',$value->id)->orderBy('id', 'desc')->take(6)->get();
            foreach ($myItem as $key1 => $value1) {
                $item.="<li><span>".$value1->created_at->format('Y-m-d')."</span><a href=\"/content?id=".$value1->id."\">".$value1->title."</a></li>";
            }
            $item.='</ul></div>';
        }
        $re=[];
        $re['menu']=$menu;
        $re['item']=$item;
        return $re;
    }
}
