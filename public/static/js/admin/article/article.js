/**
 * 文章列表
 * @author WeiZeng
 */

// 排序
Common.sort('sortBtn', 'article_id', Common.articleSort);

// 启用
Common.setStatus('enableBtn', 'article_id', 1, Common.articleSetStatus);

// 禁用
Common.setStatus('disableBtn', 'article_id', 0, Common.articleSetStatus);

// 删除
Common.setStatus('deleteBtn', 'article_id', -1, Common.articleSetStatus);
