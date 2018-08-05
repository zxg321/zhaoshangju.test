<?php

namespace Zxg321\Zmall\Controllers;

use Zxg321\Zmall\Database\City;
//use Zxg321\Zmall\AdminAudit;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Database\Menu;
use Illuminate\Support\Facades\Cache;
use Encore\Admin\Auth\Database\Administrator;
class CityController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    //protected $code=['index'=>'网站首页','newsindex'=>'新闻首页','newslist'=>'新闻列表','content'=>'内容显示'];
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('地区城市');
            $content->description('地区城市设置');

            $content->body(City::tree());//$this->grid()
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('导航菜单');
            $content->description('');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('导航菜单');
            $content->description('');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(NetMenu::class, function (Grid $grid) {

            $grid->id('ID')->sortable();

            $grid->created_at('建立时间');
            $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(City::class, function (Form $form) {
           
                $form->display('city_id', '序号');
                $form->select('parent_id', '上级菜单')->options(City::selectOptions());
                $form->text('city_name', '标题');
                $form->number('sort_order', '排序');
                $form->switch('state', '状态');
                $form->hasMany('parent','下一级地区', function (Form\NestedForm $form) {
                    $form->text('city_name', '标题');
                    $form->number('sort_order', '排序');
                    $form->switch('state', '状态');
                });
            


        });
    }
}
