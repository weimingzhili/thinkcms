/**
 * 站点设置
 * @author WeiZeng
 */

// 保存
layui.form().on('submit(saveBtn)', function(data) {
    // 发送请求
    $.ajax({
        url: Common.systemSave,
        type: 'POST',
        dataType: 'JSON',
        data: data.field,
        success: function(result) {
            if(result['status'] === 1) {
                layer.msg(result['message'], {
                    icon: 1,
                    time: 1000
                }, function() {
                    window.location.reload();
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
