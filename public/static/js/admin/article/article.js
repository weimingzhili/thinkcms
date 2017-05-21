/**
 * 文章列表
 * @author WeiZeng
 */

// 全选全不选
layui.form().on('checkbox(selectAllBtn)', function(data) {
    if(data.elem.checked) {
        // 全选
        $('input[name="article_id"]:checkbox').each(function() {
            $(this).attr('checked', true);
            $(this).prop('checked', true);
        });
    } else {
        // 全不选
        $('input[name="article_id"]:checkbox').each(function() {
            $(this).attr('checked', false);
            $(this).prop('checked', false);
        });
    }

    // 重新渲染表单
    layui.form().render('checkbox');
});

// 推送
layui.form().on('submit(pushBtn)', function(data) {
    // 获取推送数据
    var pushData      = {};
    var articleIdData = [];
    var articleData   = $('input[name="article_id"]:checkbox').serializeArray();
    if(!articleData.length) {
        layer.alert('请勾选需要推送的文章', {
            title: '操作提示',
            icon: 0
        });

        return false;
    }

    // 组合数据
    $.each(articleData, function (i) {
        articleIdData[i]            = {};
        articleIdData[i][this.name] = this.value;
    });
    pushData.articleIdData = articleIdData;
    pushData.position_id   = data.field.position_id;

    // 推送请求
    $.ajax({
        url: Common.push,
        type: 'POST',
        dataType: 'JSON',
        data: pushData,
        success: function(result) {
            if(result['status'] === 1) {
                layer.confirm(result['message'], {
                    title: '成功提示',
                    icon: 1,
                    btn: ['继续推送', '转到推荐位内容列表']
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

// 排序
Common.sort('sortBtn', 'article_id', Common.articleSort);

// 启用
Common.setStatus('enableBtn', 'article_id', 1, Common.articleSetStatus);

// 禁用
Common.setStatus('disableBtn', 'article_id', 0, Common.articleSetStatus);

// 删除
Common.setStatus('deleteBtn', 'article_id', -1, Common.articleSetStatus);

// 跳转到编辑页
$('.editBtn').click(function() {
    // 获取文章主键
    var article_id = $(this).data('article_id');
    if(!article_id) {
        layer.alert('发生错误', {
            title: '错误提示',
            icon: 2
        });

        return false;
    }

    // 转到编辑页
    window.location.href = Common.articleEdit + '.html?article_id=' + article_id;
});
