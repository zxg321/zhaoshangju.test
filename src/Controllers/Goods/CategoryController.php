<?php

namespace Zxg321\Zmall\Controllers\Goods;

use Zxg321\Zmall\Database\Goods\Category;
//use Zxg321\Zmall\AdminAudit;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Database\Menu;
use Illuminate\Support\Facades\Cache;
//use Encore\Admin\Auth\Database\Administrator;
class CategoryController extends Controller
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

            $content->header('商品分类');
            $content->description('商品分类设置');
            $uid=@request()->input('uid');
            if($uid>0)
                $content->body(Category::tree(function ($tree) use ($uid) {
                    $tree->query(function ($model) use ($uid) {
                        return $model->where('store_id', $uid);
                    });
                }));
            else
                $content->body(Category::tree(function ($tree) {
                    $tree->query(function ($model) {
                        return $model->where('store_id', 0);
                    });
                }));
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

            $content->header('商品分类');
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

            $content->header('商品分类');
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
        return Admin::grid(Category::class, function (Grid $grid) {

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
        return Admin::form(Category::class, function (Form $form) {
           
                $form->display('cate_id', '序号');
                //$form->select('parent_id', '上级菜单')->options(Category::selectOptions());
                $form->text('cate_name', '标题');
                $form->number('sort_order', '排序');
                $form->switch('if_show', '状态');
                $form->icon('cate_logo', '图标');
                $form->switch('is_logistics', '是否需要物流');
                $form->image('image_logo', '图片');
                $form->hasMany('parent','下一级商品菜单', function (Form\NestedForm $form) {
                    $form->text('cate_name', '标题');
                    $form->number('sort_order', '排序');
                    $form->switch('if_show', '状态');
                    $form->icon('cate_logo', '图标');
                    $form->switch('is_logistics', '是否需要物流');
                    $form->image('image_logo', '图片');
                });
            


        });
    }
}
