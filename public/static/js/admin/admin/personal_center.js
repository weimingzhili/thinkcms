/**
 * 个人中心
 * @author WeiZeng
 */

// 表单验证
layui.form().verify({
    // 账号
    account: function(value) {
        if(!new RegExp('^[A-Za-z0-9\-\_]+$').test(value)) {
            return '账号只能由数字、大小写字母、下划线和破折号组成';
        }
        if(value.length > 20) {
            return '账号长度在20个字符及以内';
        }
    },
    real_name: function(value) {
        if(value.length > 60) {
            return '人名长度在60个字符及以内';
        }
    }
});

// 保存
layui.form().on('submit(saveBtn)', function(data) {
    // 发送请求
    $.ajax({
        url: Common.personalCenter,
        type: 'POST',
        dataType: 'JSON',
        data: data.field,
        success: function (result) {
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
