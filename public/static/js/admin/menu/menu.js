/**
 * 菜单列表
 * @author WeiZeng
 */

// 排序
Common.sort('sortBtn', 'menu_id', Common.menuSort);

// 启用
Common.setStatus('enableBtn', 'menu_id', 1, Common.menuSetStatus);

// 禁用
Common.setStatus('disableBtn', 'menu_id', 0, Common.menuSetStatus);

// 删除
Common.setStatus('deleteBtn', 'menu_id', -1, Common.menuSetStatus);
