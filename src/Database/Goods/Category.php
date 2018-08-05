<?php

namespace Zxg321\Zmall\Database\Goods;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
class Category extends Model
{
    use ModelTree, AdminBuilder;
    //protected $table = 'zmall_net_menu';
    protected $primaryKey='cate_id';
    //public $timestamps = false;//时间戳关闭 created_at 和 updated_at 字段
    //public $guarded = ['sort_order'];//黑名单属性
    //protected $casts = ['audit_list' => 'array',];
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('zmall.db_prefix','zmall_').'goods_category');
        parent::__construct($attributes);
        //$this->setParentColumn('parent_id');
        $this->setOrderColumn('sort_order');
        $this->setTitleColumn('cate_name');
        //$this->where('store_id',0);
    }
    public function parent()
    {
         return $this->hasMany('Zxg321\Zmall\Database\Goods\Category','parent_id','cate_id');
    }
    public function main()
    {
        return $this->belongsTo('Zxg321\Zmall\Database\Goods\Category','parent_id','cate_id');
    }
    
}
