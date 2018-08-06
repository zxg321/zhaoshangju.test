<?php

namespace Zxg321\Zmall\Database\Goods;

use Illuminate\Database\Eloquent\Model;
//use Encore\Admin\Traits\AdminBuilder;
//use Encore\Admin\Traits\ModelTree;
class Spec extends Model
{
    //use ModelTree, AdminBuilder;
    //protected $table = 'zmall_net_menu';
    //protected $primaryKey='cate_id';
    public $timestamps = false;//时间戳关闭 created_at 和 updated_at 字段
    //public $guarded = ['sort_order'];//黑名单属性
    //protected $casts = ['audit_list' => 'array',];
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('zmall.db_prefix','zmall_').'goods_spec');
        parent::__construct($attributes);
    }
    public function goods()
    {
         return $this->belongsTo('Zxg321\Zmall\Database\Goods\Item','goods_id','id');
    }
}
