<?php

namespace Zxg321\Zmall\Controllers\Ad;

use Zxg321\Zmall\Database\Ad\Menu;
//use Zxg321\Zmall\AdminAudit;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
//use Encore\Admin\Auth\Database\Menu;
//use Illuminate\Support\Facades\Cache;
//use Encore\Admin\Auth\Database\Administrator;
class MenuController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    //protected $code=['index'=>'网站首页','newsindex'=>'新闻首页','newslist'=>'新闻列表','content'=>'内容显示'];
    protected $title='广告分类';
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->title);
            $content->description($this->title.'设置');
            $content->body($this->grid());
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

            $content->header($this->title);
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

            $content->header($this->title);
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
        return Admin::grid(Menu::class, function (Grid $grid) {

            $grid->id('序号')->sortable();
            $grid->title('标题')->editable();
            $grid->sort_order('排序')->editable('number');
            $grid->st('状态')->switch();
            $grid->model()->orderBy('sort_order');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Menu::class, function (Form $form) {
           
                $form->display('id', '序号');
                $form->text('title', '标题');
                $form->number('sort_order', '排序');
                $form->switch('st', '状态');
                $form->text('cate_desc', '描述');
                $form->text('text', '文字显示');
                $form->text('key_words', '关键字');
                $form->hasMany('item','广告列表', function (Form\NestedForm $form) {
                    $form->text('title', '标题');
                    $form->number('sort_order', '排序');
                    $form->text('name', '广告名');
                    $form->switch('st', '状态');
                    $form->text('key_words', '关键字');
                    $form->text('text', '文字显示');
                    $form->image('logo', '展示图片');
                    $form->text('url', '连接');
                    //$form->image('image_logo', '图片');
                });
            


        });
    }
}
