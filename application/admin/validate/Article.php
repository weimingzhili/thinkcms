<?php

namespace app\admin\validate;

use think\Validate;

/**
 * 文章管理器
 * @author WeiZeng
 */
class Article extends Validate
{
    // 验证规则
    protected $rule = [
        'article_id|序号'     => 'require|number|gt:0',
        'column_id|栏目'      => 'require|number|gt:0',
        'title|文章标题'      => 'require|max:150',
        'subtitle|子标题'     => 'max:300',
        'thumb|缩略图'        => 'max:255',
        'list_order|排序序号' => 'require|number|egt:0',
        'source|来源'         => 'max:255',
        'admin|管理员账号'    => 'require|require|alphaDash|max:20',
        'status|状态'         => 'require|number|in:-1,0,1',
        'content|文章内容'    => 'require|max:65532',
        'readings|阅读数'     => 'require|number|egt:0',
        'pushData'           => 'checkPush',
    ];

    // 验证场景
    protected $scene = [
        // 主键
        'pk'             => 'article_id',
        // 筛选
        'filter'         => ['column_id' => 'number', 'title' => 'max:60'],
        // 排序
        'sort'           => ['article_id', 'list_order'],
        // 设置状态
        'setStatus'      => ['article_id', 'status'],
        // 添加
        'add'            => ['title', 'subtitle', 'thumb', 'column_id', 'source', 'content', 'description', 'keywords', 'admin'],
        // 添加文章
        'addArticle'     => ['title', 'subtitle', 'thumb', 'column_id', 'source', 'description', 'keywords', 'admin'],
        // 添加文章内容
        'addContent'     => ['article_id', 'content'],
        // 保存
        'save'           => ['title', 'subtitle', 'thumb', 'column_id', 'source', 'content', 'description', 'keywords', 'admin', 'article_id'],
        // 保存文章
        'saveArticle'    => ['title', 'subtitle', 'thumb', 'column_id', 'source', 'description', 'keywords', 'admin', 'article_id'],
        // 保存文章内容
        'saveContent'    => ['article_id', 'content'],
        // 推送
        'push'           => 'pushData',
        // 更新阅读数
        'updateReadings' => ['article_id', 'readings'],
    ];

    /**
     * 推送验证规则
     * @access public
     * @param array $data 推送数据
     * @return string|bool
     */
    public function checkPush($data)
    {
        // 验证推荐位
        if(!preg_match('/^[1-9]\d*$/', $data['position_id'])) {
            return '推荐位验证失败';
        }

        // 验证文章id
        foreach($data['articleIdData'] as $value) {
            if(!preg_match('/^[1-9]\d*$/', $value['article_id'])) {
                return '文章序号验证失败';
            }
        }

        return true;
    }
}
