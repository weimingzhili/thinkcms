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
    menu: '/menu',          // 列表
    menuSort: '/menu/sort', // 排序
    menuSetStatus: '/menu/setStatus', // 设置状态

    // 排序
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
    // 设置状态
    setStatus: function(className, pk, status, url) {
        $('.' + className).click(function() {
            // 获取数据
            var id = $(this).data(pk);
            var data = {status: status}
            data[pk] = id;
            // 确认操作
            layer.confirm('确认操作', {
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
