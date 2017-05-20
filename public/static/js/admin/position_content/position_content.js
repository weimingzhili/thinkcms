/**
 * 推荐位内容列表
 * @author WeiZeng
 */

// 排序
Common.sort('sortBtn', 'position_content_id', Common.positionContentSort);

// 启用
Common.setStatus('enableBtn', 'position_content_id', 1, Common.positionContentSetStatus);

// 禁用
Common.setStatus('disableBtn', 'position_content_id', 0, Common.positionContentSetStatus);

// 删除
Common.setStatus('deleteBtn', 'position_content_id', -1, Common.positionContentSetStatus);
