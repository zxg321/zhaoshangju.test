<?php

namespace Zxg321\Zmall\Database;

use Illuminate\Database\Eloquent\Model;
use Zxg321\Zmall\Database\NetMenu;
class NetContent extends Model
{
    //protected $table = 'zmall_net_content';
    //protected $primaryKey='id';
    protected $casts = [
        'audit_json' => 'json',
    ];
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('zmall.db_prefix','zmall_').'net_content');
        //
        //parent::__construct($attributes);

        //$this->setParentColumn('parent_id');
        //$this->setOrderColumn('sort_order');
        //$this->setTitleColumn('cate_name');
    }
    public function category()
    {
        return $this->belongsTo(NetMenu::class);
    }
}
