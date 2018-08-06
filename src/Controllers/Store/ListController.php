<?php

namespace Zxg321\Zmall\Controllers\Store;

use Zxg321\Zmall\Database\Store\Item;
//use Zxg321\Zmall\AdminAudit;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Auth\Database\Menu;
//use Illuminate\Support\Facades\Cache;
//use Encore\Admin\Auth\Database\Administrator;
class ListController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    //protected $code=['index'=>'网站首页','newsindex'=>'新闻首页','newslist'=>'新闻列表','content'=>'内容显示'];
    protected $title='店铺';
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
        return Admin::grid(Item::class, function (Grid $grid) {

            $grid->id('序号')->sortable();
            $grid->title('标题')->editable();
            $grid->sort_order('排序')->editable('number');
            $grid->recommended('推荐')->switch();
            $grid->st('状态')->switch();
            $grid->address('地址')->editable();
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
        return Admin::form(Item::class, function (Form $form) {
           
            $form->display('id', '序号');
            //$form->select('parent_id', '上级菜单')->options(Category::selectOptions());
            $form->text('title', '标题');
            $form->number('sort_order', '排序');
            $form->switch('recommended', '推荐');
            $form->switch('st', '状态');
            $form->text('address', '地址');
            


        });
    }
}
