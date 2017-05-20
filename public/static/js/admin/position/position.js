/**
 * 推荐位列表
 * @author WeiZeng
 */

// 启用
Common.setStatus('enableBtn', 'position_id', 1, Common.positionSetStatus);

// 禁用
Common.setStatus('disableBtn', 'position_id', 0, Common.positionSetStatus);

// 删除
Common.setStatus('deleteBtn', 'position_id', -1, Common.positionSetStatus);

// 跳转到编辑页
$('.editBtn').click(function() {
    // 获取主键
    var position_id = $(this).data('position_id');
    if(!position_id) {
        layer.alert('发生错误', {
            title: '错误提示',
            icon: 2
        });

        return false;
    }


    // 转到编辑页
    window.location.href = Common.positionEdit + '.html?position_id=' + position_id;
});
