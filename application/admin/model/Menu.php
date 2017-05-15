<?php

namespace app\admin\model;

use think\Exception;

use think\Model;

/**
 * 菜单模型
 * @author WeiZeng
 */
class Menu extends Model
{
    /**
     * 类型获取器
     * @access public
     * @param int $type 菜单类型
     * @return string
     */
    public function getTypeAttr($type)
    {
        return $type == 1 ? '前台导航' : '后台菜单';
    }

    /**
     * 状态获取器
     * @access public
     * @param int $status 状态
     * @return string
     */
    public function getStatusAttr($status)
    {
        return $status == 1 ? '启用' : '禁用';
    }

    /**
     * 获取菜单
     * @access public
     * @param int $menu_id 菜单主键
     * @return object
     */
    public function getMenu($menu_id)
    {
        // 查询记录
        $menu = self::get($menu_id);

        return $menu;
    }

    /**
     * 获取所有栏目
     * @access public
     * @return array
     */
    public function getColumnAll()
    {
        // 查询记录
        $columns = self::all(['type' => 1, 'status' => 1]);

        return $columns;
    }

    /**
     * 获取所有后台菜单
     * @access public
     * @return object
     */
    public function getAdminMenuAll()
    {
        // 查询记录
        $menuAll = self::all(function($query) {
            $query->where(['type' => 2, 'status' => 1])
                  ->order(['list_order' => 'desc', 'menu_id' => 'desc']);
        });

        return $menuAll;
    }

    /**
     * 获取菜单总数
     * @access public
     * @return int
     */
    public function getMenuTotal()
    {
        // 统计记录
        $total = self::where(['status' => ['<>', '-1']])->count();

        return $total;
    }

    /**
     * 菜单分页
     * @access public
     * @param array $where 查询条件
     * @param array $query 查询参数
     * @return array
     */
    public function menuPaginate($where, $query) {
        // 获取分页记录
        $pageList = self::where($where)
                    ->order(['list_order' => 'desc', 'menu_id' => 'desc'])
                    ->paginate(5, false, $query);
        // 获取分页导航
        $pageNav = $pageList->render();

        return ['pageList'=> $pageList, 'pageNav' => $pageNav];
    }

    /**
     * 菜单添加
     * @access public
     * @param array $data 添加数据
     * @return bool
     * @throws Exception
     */
    public function menuAdd($data)
    {
        // 插入记录
        $result = $this->validate('Menu.add')
                  ->allowField(['menu_name', 'type', 'module', 'controller', 'action', 'status'])
                  ->save($data);
        if($result === false) {
            throw new Exception('添加出错');
        }

        return true;
    }

    /**
     * 菜单排序
     * @access public
     * @param array $data 排序数据
     * @return bool
     * @throws Exception
     */
    public function menuSort($data)
    {
        // 批量更新
        $result = $this->validate('Menu.sort')->saveAll($data);
        if($result === false) {
            throw new Exception('排序更新出错');
        }

        return true;
    }

    /**
     * 更新状态
     * @access public
     * @param array $data 更新数据
     * @return bool
     * @throws Exception
     */
    public function updateStatus($data)
    {
        // 更新记录
        $result = $this->validate('Menu.setStatus')
                  ->save($data, ['menu_id' => $data['menu_id']]);
        if($result === false) {
            throw new Exception('更新状态出错');
        }

        return true;
    }

    /**
     * 菜单更新
     * @access public
     * @param array $data 更新数据
     * @return bool
     * @throws Exception
     */
    public function menuUpdate($data)
    {
        // 更新记录
        $result = $this->validate('Menu.edit')
                  ->allowField(['menu_name', 'type', 'module', 'controller', 'action', 'status'])
                  ->save($data, ['menu_id' => $data['menu_id']]);
        if($result === false) {
            throw new Exception('更新出错');
        }

        return true;
    }
}
