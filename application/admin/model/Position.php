<?php

namespace app\admin\model;

use think\Exception;

use think\Model;

/**
 * 推荐位模型
 * @author WeiZeng
 */
class Position extends Model
{
    // 数据完成：新增
    protected $insert = ['create_time'];

    /**
     * 创建时间获取器
     * @access public
     * @param string $create_time 创建时间
     * @return string
     */
    public function getCreateTimeAttr($create_time)
    {
        return !empty($create_time) ? date('Y-m-d H:i:s', $create_time) : '未知';
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
     * 创建时间修改器
     * @access public
     * @return int
     */
    public function setCreateTimeAttr()
    {
        return time();
    }

    /**
     * 获取推荐位
     * @access public
     * @param int $position_id 推荐位主键
     * @return object
     */
    public function getPosition($position_id)
    {
        // 查询记录
        $position = self::get($position_id);

        return $position;
    }

    /**
     * 获取所有推荐位
     * @access public
     * @return array
     */
    public function getPositionAll()
    {
        // 查询记录
        $positionData = self::all(['status' => 1]);

        return $positionData;
    }

    /**
     * 分页
     * @access public
     * @return array
     */
    public function positionPaginate()
    {
        // 获取分页记录
        $pageList = self::where(['status' => ['<>', -1]])
                    ->order(['position_id' => 'desc'])
                    ->paginate(5);
        // 获取分页导航
        $pageNav = $pageList->render();

        return ['pageList' => $pageList, 'pageNav' => $pageNav];
    }

    /**
     * 推荐位添加
     * @access public
     * @param array $data 添加数据
     * @return bool
     * @throws Exception
     */
    public function positionAdd($data)
    {
        // 插入记录
        $result = $this->validate('Position.add')
                  ->allowField(['position_name', 'description', 'status'])
                  ->save($data);
        if($result === false) {
            throw new Exception('添加出错');
        }

        return true;
    }

    /**
     * 推荐位更新
     * @access public
     * @param array $data 更新数据
     * @return bool
     * @throws Exception
     */
    public function positionUpdate($data)
    {
        // 更新记录
        $result = $this->validate('Position.edit')
                  ->allowField(['position_name', 'description', 'status'])
                  ->save($data, ['position_id' => $data['position_id']]);
        if($result === false) {
            throw new Exception('更新出错');
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
        $result = $this->validate('Position.setStatus')
                  ->save($data, ['position_id' => $data['position_id']]);
        if($result === false) {
            throw new Exception('更新状态出错');
        }

        return true;
    }
}
