/**
 * 推荐位编辑
 * @author WeiZeng
 */

// 表单验证
layui.form().verify({
    // 推荐位名称
    position_name: function(value) {
        if(value.length > 60) {
            return '推荐位名称长度在20个字符及以内';
        }
    },
    // 推荐位描述
    description: function(value) {
        if(value.length > 150) {
            return '推荐位描述长度在150个字符及以内';
        }
    }
});

// 编辑
layui.form().on('submit(saveBtn)', function(data) {
    // 发送请求
    $.ajax({
        url: Common.positionEdit,
        type: 'POST',
        dataType: 'JSON',
        data: data.field,
        success: function(result) {
            if(result['status'] === 1) {
                layer.msg(result['message'], {
                    icon: 1,
                    time: 1000
                }, function() {
                    window.location.href = Common.position;
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
});
