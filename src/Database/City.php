<?php

namespace Zxg321\Zmall\Database;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
class City extends Model
{
    use ModelTree, AdminBuilder;
    //protected $table = 'zmall_net_menu';
    protected $primaryKey='city_id';
    //public $timestamps = false;//时间戳关闭 created_at 和 updated_at 字段
    //public $guarded = ['sort_order'];//黑名单属性
    //protected $casts = ['audit_list' => 'array',];
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('zmall.db_prefix','zmall_').'city');
        parent::__construct($attributes);

        //$this->setParentColumn('parent_id');
        $this->setOrderColumn('sort_order');
        $this->setTitleColumn('city_name');
    }
    public function parent()
    {
         return $this->hasMany('Zxg321\Zmall\Database\City','parent_id','city_id');
    }
    public function main()
    {
        return $this->belongsTo('Zxg321\Zmall\Database\City','parent_id','city_id');
    }
    
}
