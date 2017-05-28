/**
 * 前台首页
 * @author WeiZeng
 */

// 轮播
$(function () {
    // 获取轮播容器
    var collapseContainer = $('.swiper-container');
    // 创建轮播
    var swiper = collapseContainer.swiper({
        autoplay: 3000, // 自动摆放间隔
        speed: 1000,    // 滑动速度
        loop: true      // 循环播放
    });

    // 鼠标悬停
    collapseContainer.hover(function() {
        swiper.stopAutoplay();
    }, function() {
        swiper.startAutoplay()
    });
});
