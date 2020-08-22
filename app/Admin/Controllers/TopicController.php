<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Models\TopicsModel;
use App\Models\TopicsOptionsModel;

class TopicController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '话题管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TopicsModel);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', '名称');
        $grid->column('uid', 'uid');
        $grid->column('status', 'status')->using(['0' => '关闭', '1' => '开始']);
        $grid->column('start_time', '开始时间');
        $grid->column('end_time', '结束时间')->date('Y-m-d H:i:s');
        $grid->column('type', '类型')->using(['1' => '单选', '2' => '多选']);
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(TopicsModel::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', '名称');
        $show->field('uid', 'uid');
        $show->field('status', 'status');
        $show->field('start_time', '开始时间');
        $show->field('end_time', '结束时间');
        $show->field('type', '类型');
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TopicsModel);

        $form->display('id', __('ID'));
        $status = ['关闭', '开始'];
        $form->text('name', '名称');
        $form->select('status', '状态')->options($status);
        $form->datetime('start_time', '开始时间');
        $form->datetime('end_time', '结束时间');
        
        $type = ['1' => '单选', '2' => '多选'];
        $form->select('type', '类型')->options($type);
        $form->display('created_at', __('Created At'));
        $form->display('updated_at', __('Updated At'));

        $form->hasMany('topics_list', '选项', function(Form\NestedForm $form) {
            $form->text('name', '答复');
        });

        $form->saving(function (Form $form) {
            $form->start_time = strtotime($form->start_time);
            $form->end_time = strtotime($form->end_time);
        });

        $form->saved(function (Form $form) {

        });
        return $form;
    }
}
