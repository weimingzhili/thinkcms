/**
 * 推荐位内容列表
 * @author WeiZeng
 */

// 排序
Common.sort('sortBtn', 'position_content_id', Common.positionContentSort);

// 启用
Common.setStatus('enableBtn', 'position_content_id', 1, Common.positionContentSetStatus);

// 禁用
Common.setStatus('disableBtn', 'position_content_id', 0, Common.positionContentSetStatus);

// 删除
Common.setStatus('deleteBtn', 'position_content_id', -1, Common.positionContentSetStatus);

// 跳转到编辑页
$('.editBtn').click(function() {
    // 获取推荐位内容主键
    var position_content_id = $(this).data('position_content_id');
    if(!position_content_id) {
        layer.alert('发生错误', {
            title: '错误提示',
            icon: 2
        });

        return false;
    }

    // 跳转到编辑页
    window.location.href = Common.positionContentEdit + '.html?position_content_id=' + position_content_id;
});
