/**
 * 管理员列表
 * @author WeiZeng
 */

// 启用
Common.setStatus('enableBtn', 'admin_id', 1, Common.adminSetStatus);

// 禁用
Common.setStatus('disableBtn', 'admin_id', 0, Common.adminSetStatus);

// 删除
Common.setStatus('deleteBtn', 'admin_id', -1, Common.adminSetStatus);
