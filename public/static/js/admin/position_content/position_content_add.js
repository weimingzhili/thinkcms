/**
 * 推荐位内容添加
 * @author WeiZeng
 */

// 缩略图上传
layui.upload({
    url: '/upload',
    success: function(result) {
        if(result['code'] === 0) {
            // 获取预览
            var thumb = $('#thumb');
            // 保存上传路径
            $('input[name="thumb"]').val(result['data']['src']);
            // 渲染上传表单盒子
            $('.upload-bar').addClass('upload-form-box');
            // 渲染上传按钮盒子
            $('.layui-upload-button').addClass('uploaded-button');
            // 给预览添加路径
            thumb.attr('src', result['data']['src']);
            // 展示预览
            thumb.show();
        }
        if(result['code'] === -1) {
            layer.alert(result['msg'], {
                title: '错误提示',
                icon: 2
            });
        }
    }
});

// 表单验证
layui.form().verify({
    // 标题
    title: function(value) {
        if(value.length > 150) {
            return '标题长度在150个字符及以内';
        }
    },
    // 地址
    address: function(value) {
        if(value.length > 255) {
            return '来源长度在255个字符及以内';
        }
    },
    // 文章序号
    article_id: function(value) {
        if(!new RegExp('^[1-9]\d*$').test(value)) {
            return '文章序号只能是正整数';
        }
    }
});


// 添加
layui.form().on('submit(addBtn)', function(data) {
    // 判断添加数据是否符合要求
    if(!data.field.article_id) {
        if(!data.field.address) {
            layer.alert('请填写文章地址或文章序号', {
                title: '错误提示',
                icon: 2
            });

            return false;
        }

        if(!data.field.thumb) {
            layer.alert('添加站外文章必须上传缩略图！', {
                title: '错误提示',
                icon: 2
            });

            return false;
        }
    }

    // 添加请求
    $.ajax({
        url: Common.positionContentAdd,
        type: 'POST',
        dataType: 'JSON',
        data: data.field,
        success: function(result) {
            if(result['status'] === 1) {
                layer.confirm('添加成功', {
                    title: '成功提示',
                    icon: 1,
                    btn: ['继续添加', '转到列表']
                }, function() {
                    window.location.reload();
                }, function() {
                    window.location.href = Common.positionContent;
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
