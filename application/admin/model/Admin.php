<?php

namespace app\admin\model;

use think\Exception;

use think\Model;

/**
 * 管理员模型
 * @author WeiZeng
 */
class Admin extends Model
{
    /**
     * 最后登录时间获取器
     * @access public
     * @param int $last_login_time 最后登录的时间戳
     * @return string
     */
    public function getLastLoginTimeAttr($last_login_time)
    {
        return !empty($last_login_time) ? date('Y年n月j日G时i分s秒', $last_login_time) : '未知';
    }

    /**
     * 最后登录ip获取器
     * @access public
     * @param string $last_login_ip 最后登录的ip
     * @return string
     */
    public function getLastLoginIpAttr($last_login_ip)
    {
        return !empty($last_login_ip) ? $last_login_ip : '未知';
    }

    /**
     * 类型获取器
     * @access public
     * @param int $type 类型
     * @return string
     */
    public function getTypeAttr($type)
    {
        return $type == 1 ? '超级管理员' : '管理员';
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
     * 根据账号获取管理员
     * @access public
     * @param string $account 账号
     * @return object
     */
    public function getAdminByAccount($account)
    {
        // 查询记录
        $admin = self::get(['account' => $account, 'status' => 1]);

        return $admin;
    }

    /**
     * 获取管理员总数
     * @access public
     * @return int
     */
    public function getAdminTotal()
    {
        // 统计记录
        $total = self::where(['status' => ['<>', -1]])->count();

        return $total;
    }

    /**
     * 分页
     * @access public
     * @return array
     */
    public function adminPaginate()
    {
        // 获取分页记录
        $pageList = self::where(['status' => ['<>', -1]])
                    ->order(['admin_id' => 'desc'])
                    ->paginate(5);
        // 获取分页导航
        $pageNav = $pageList->render();

        return ['pageList' => $pageList, 'pageNav' => $pageNav];
    }

    /**
     * 登录验证
     * @access public
     * @param string $account 账号
     * @param string $password 密码
     * @return bool|object
     */
    public function loginCheck($account, $password)
    {
        // 获取管理员记录
        $admin = $this->getAdminByAccount($account);
        // 若记录不存在
        if(empty($admin)) {
            return false;
        }

        // 比对密码
        if(encryptPassword($password) == $admin->getAttr('password')) {
            return $admin;
        }

        return false;
    }

    /**
     * 登录更新
     * @access public
     * @param array $data 更新数据
     * @return bool
     * @throws Exception
     */
    public function loginUpdate($data)
    {
        // 更新记录
        $result = $this->allowField(['last_login_time', 'last_login_ip'])
                ->save($data, ['account' => $data['account'], 'status' => 1]);
        if($result === false) {
            throw new Exception('登录更新失败');
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
        $result = $this->validate('Admin.setStatus')
                  ->save($data, ['admin_id' => $data['admin_id']]);
        if($result === false) {
            throw new Exception('更新状态出错');
        }

        return true;
    }
}
