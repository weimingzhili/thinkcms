/**
 * 文章编辑
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

// 若缩略图存在，显示预览
if($('input[name="thumb"]').val()) {
    // 渲染上传表单盒子
    $('.upload-bar').addClass('upload-form-box');
    // 渲染上传按钮盒子
    $('.layui-upload-button').addClass('uploaded-button');
    // 展示预览
    $('#thumb').show();
}

// 文章内容插入图片
layui.layedit.set({
    uploadImage: {
        url: '/upload',
        type: 'post'
    }
});
// Layedit初始化
var index = layui.layedit.build('content');

// 表单验证
layui.form().verify({
    // 标题
    title: function(value) {
        if(value.length > 150) {
            return '标题长度在150个字符及以内';
        }
    },
    // 子标题
    subtitle: function(value) {
        if(value.length > 300) {
            return '子标题长度在300个字符及以内';
        }
    },
    // 来源
    source: function(value) {
        if(value.length > 255) {
            return '来源长度在255个字符及以内';
        }
    },
    // 描述
    description: function(value) {
        if(value.length > 600) {
            return '描述长度在600个字符及以内';
        }
    },
    // 关键词
    keywords: function(value) {
        if(value.length > 120) {
            return '关键词总长度在120个字符及以内';
        }
    }
});

// 保存
layui.form().on('submit(saveBtn)', function(data) {
    // 获取文章内容
    var content = layui.layedit.getContent(index);
    if(!content) {
        layer.alert('请填写文章内容', {
            title: '错误提示',
            icon: 2
        });

        return false;
    }
    if(content.length > 65532) {
        layer.alert('文章内容长度在65532个字符及以内', {
            title: '错误提示',
            icon: 2
        });

        return false;
    }

    // 覆盖掉字段数据中的文章内容
    data.field.content = content;

    $.ajax({
        url: Common.articleEdit,
        type: 'POST',
        dataType: 'JSON',
        data: data.field,
        success: function(result) {
            if(result['status'] === 1) {
                layer.msg(result['message'], {
                    icon: 1,
                    time: 1000
                }, function() {
                    window.location.href = Common.article;
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
