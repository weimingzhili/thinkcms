/**
 * 文章列表
 * @author WeiZeng
 */

// 排序
Common.sort('sortBtn', 'article_id', Common.articleSort);

// 启用
Common.setStatus('enableBtn', 'article_id', 1, Common.articleSetStatus);

// 禁用
Common.setStatus('disableBtn', 'article_id', 0, Common.articleSetStatus);

// 删除
Common.setStatus('deleteBtn', 'article_id', -1, Common.articleSetStatus);

// 跳转到编辑页
$('.editBtn').click(function() {
    // 获取文章序号
    var article_id = $(this).data('article_id');
    if(!article_id) {
        layer.alert('发生错误', {
            title: '操作提示',
            icon: 2
        });

        return false;
    }

    window.location.href = Common.articleEdit + '.html?article_id=' + article_id;
});
