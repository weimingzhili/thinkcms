/* 菜单添加 */

// 表单验证
layui.form().verify({
    // 菜单名称
    menuName: function(value) {
        if(value.length > 60) {
            return '菜单名称在60个字符及以内';
        }
    },
    // 模块
    module: function(value) {
        if(!new RegExp('^[A-Za-z]+$').test(value)) {
            return '模块只能由英文字母组成';
        }
        if(value.length > 50) {
            return '模块在50个字符及以内';
        }
    },
    // 控制器
    controller: function(value) {
        if(!new RegExp('^[A-Za-z]+$').test(value)) {
            return '控制器只能由英文字母组成';
        }
        if(value.length > 50) {
            return '控制器在50个字符及以内';
        }
    },
    // 方法
    action: function(value) {
        if(!new RegExp('^[A-Za-z]+$').test(value)) {
            return '方法只能由英文字母组成';
        }
        if(value.length > 50) {
            return '方法在50个字符及以内';
        }
    }
});

// 添加
layui.form().on('submit(addBtn)', function(data) {
    // 发送请求
    $.ajax({
        url: Common.menuAdd,
        type: 'POST',
        dataType: 'JSON',
        data: data.field,
        success: function(result) {
            if(result['status'] === 1) {
                layer.confirm(result['message'], {
                    title: '成功提示',
                    icon: 1,
                    btn: ['继续添加', '转到列表']
                }, function() {
                    window.location.reload();
                }, function() {
                    window.location.href = Common.menu;
                });
            }
            if(result['status'] === 0) {
                layer.alert(result['message'], {
                    title: '错误提示',
                    icon: 2
                });
            }
        }
    });

    // 禁止表单提交
    return false;
})
