/**
 * 后台通用类
 * @author WeiZeng
 */
var Common = {
    // 后台登录
    login: '/loginCheck',

    // 后台首页
    dashboard: '/dashboard',

    // 菜单管理
    menu: '/menu',                    // 列表
    menuSort: '/menu/sort',           // 排序
    menuAdd: '/menu/add',             // 添加
    menuEdit: '/menu/edit',           // 编辑
    menuSetStatus: '/menu/setStatus', // 设置状态

    // 文章管理
    article: '/article',                   // 列表
    articleAdd: '/article/add',            // 添加
    articleSort: '/article/sort',          // 排序
    articleSetStatus: 'article/setStatus', // 设置状态
    upload: '/upload',                     // 上传
    articleEdit: '/article/edit',          // 编辑
    push: '/push',                         // 推送

    // 推荐位管理
    position: '/position',                    // 列表
    positionSetStatus: '/position/setStatus', // 设置状态
    positionAdd: '/position/add',             // 添加
    positionEdit: '/position/edit',           // 编辑

    // 推荐位内容
    positionContent: '/positionContent',                    // 列表
    positionContentSort: '/positionContent/sort',           // 排序
    positionContentSetStatus: '/positionContent/setStatus', // 设置状态
    positionContentAdd: '/positionContent/add',             // 添加
    positionContentEdit: '/positionContent/edit',           // 编辑

    // 管理员管理
    admin: '/admin',                    // 列表
    adminAdd: '/admin/add',             // 添加
    adminSetStatus: '/admin/setStatus', // 设置状态
    personalCenter: '/personalCenter',  // 个人中心

    // 排序，需传入排序按钮的事件过滤器、主键和请求方法的url
    sort: function(filter, pk, url) {
        layui.form().on('submit(' + filter + ')', function(data) {
            // 获取排序数据
            var sortData = [];
            var k = 0;
            $.each(data.field, function(i) {
                sortData[k] = {list_order: data.field[i]};
                sortData[k][pk] = i;

                k++;
            });

            // 发送请求
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: {sortData: sortData},
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
    },
    // 设置状态，需传入操作按钮的类名、主键、状态值以及请求方法的url
    setStatus: function(className, pk, status, url) {
        $('.' + className).click(function() {
            // 获取数据
            var id = $(this).data(pk);
            var data = {status: status}
            data[pk] = id;
            // 确认操作
            layer.confirm('是否确认操作?', {
                title: '操作提示',
                icon: 3
            }, function() {
                // 发送请求
                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'JSON',
                    data: data,
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
            }, function() {});
        });
    }
};
