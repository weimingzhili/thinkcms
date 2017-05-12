/**
 * 登录
 * @author WeiZeng
 */

// 点击刷新验证码
var captchaImg = $('#captchaImg')
captchaImg.click(function() {
    captchaImg.attr('src', '/captcha.html');
});

// 表单验证
layui.form().verify({
    // 账号
    account: function(value) {
        if(!new RegExp('^[A-Za-z0-9\-\_]+$').test(value)) {
            return '账号由大小写字母、数字、下划线和破折号组成';
        }
        if(value.length > 20) {
            return '账号长度在20个字符及以内';
        }
    },
    // 验证码
    captcha: function(value) {
        if(!new RegExp('^[A-Za-z0-9]+$').test(value)) {
            return '验证码由数字和大小写字母组成';
        }
        if(value.length !== 4) {
            return '验证码长度为4位';
        }
    }
});

// 登录
layui.form().on('submit(loginBtn)', function(data) {
    // 获取登录数据
    var loginData = data.field;

    // 发送请求
    $.ajax({
        url: Common.login,
        type: 'POST',
        dataType: 'JSON',
        data: loginData,
        success: function(result) {
            if(result['status'] === 1) {
                layer.msg(result['message'], {
                    icon: 1,
                    time: 1000
                }, function () {
                    window.location.href = Common.dashboard;
                });
            }
            if(result['status'] === 0) {
                layer.alert(result['message'], {
                    title: '错误提示',
                    icon: 2,
                    end: function() {
                        $('#captchaImg').attr('src', '/captcha.html');
                    }
                });
            }
        }
    });

    // 禁止表单提交
    return false;
});
