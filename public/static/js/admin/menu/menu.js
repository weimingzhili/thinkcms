/**
 * 菜单列表
 * @author WeiZeng
 */

// 排序
Common.sort('sortBtn', 'menu_id', Common.menuSort);

// 启用
Common.setStatus('enableBtn', 'menu_id', 1, Common.menuSetStatus);

// 禁用
Common.setStatus('disableBtn', 'menu_id', 0, Common.menuSetStatus);

// 删除
Common.setStatus('deleteBtn', 'menu_id', -1, Common.menuSetStatus);

// 跳转到编辑页
$('.editBtn').click(function() {
    // 获取主键
    var menu_id = $(this).data('menu_id');
    if(!menu_id) {
        layer.alert('发生错误', {
            title: '错误提示',
            icon: 2
        });

        return false;
    }

    // 转到编辑页
    window.location.href = Common.menuEdit + '.html?menu_id=' + menu_id;
});
