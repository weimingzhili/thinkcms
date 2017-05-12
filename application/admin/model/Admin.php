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
     * 根据账号获取管理员
     * @access public
     * @param string $account 账号
     * @return object
     */
    public function getAdminByAccount($account)
    {
        // 查询记录
        $admin = self::get(['account' => $account]);

        return $admin;
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
}
