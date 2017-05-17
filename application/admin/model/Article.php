<?php

namespace app\admin\model;

use think\Exception;

use think\Loader;

use think\Model;

/**
 * 文章模型
 * @author WeiZeng
 */
class Article extends Model
{
    // 数据完成：新增
    protected $insert = ['create_time'];

    // 数据完成：更新
    protected $update = ['update_time'];

    /**
     * 与文章内容模型一对一关联
     * @access public
     * @return \think\model\relation\HasOne
     */
    public function articleContent()
    {
        return $this->hasOne('ArticleContent');
    }

    /**
     * 栏目获取器
     * @access public
     * @param int $column_id 栏目id
     * @return string
     */
    public function getColumnIdAttr($column_id)
    {
        // 栏目名
        $column_name = '';

        // 获取栏目
        $menuModel = Loader::model('Menu');
        $columnData = $menuModel->getColumnAll();

        // 获取栏目名
        foreach ($columnData as $value) {
            if($value->menu_id == $column_id) {
                $column_name = $value->menu_name;
            }
        }

        return !empty($column_name) ? $column_name : '未知';
    }

    /**
     * 缩略图获取器
     * @access public
     * @param string $thumb 缩略图
     * @return string
     */
    public function getThumbAttr($thumb)
    {
        return !empty($thumb) ? '有' : '无';
    }

    /**
     * 来源获取器
     * @access public
     * @param string $source 来源
     * @return string
     */
    public function getSourceAttr($source)
    {
        return !empty($source) ? $source : '本站';
    }

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
     * @param string $status 状态
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
     * 更新时间修改器
     * @access public
     * @return int
     */
    public function setUpdateTimeAttr()
    {
        return time();
    }

    /**
     * 获取文章总数
     * @access public
     * @return int
     */
    public function getArticleTotal()
    {
        // 统计记录
        $total = self::where(['status' => ['<>', '-1']])->count();

        return $total;
    }

    /**
     * 获取文章数据
     * @access public
     * @param int $article_id 文章序号
     * @return object
     */
    public function getArticleData($article_id)
    {
        // 预关联查询
        $articleData = self::get($article_id, 'article_content');

        return $articleData;
    }

    /**
     * 分页
     * @access public
     * @param array $where 查询条件
     * @param array $query 查询参数
     * @return array
     */
    public function articlePaginate($where, $query)
    {
        // 获取分页记录
        $pageList = self::where($where)
                    ->order(['list_order' => 'desc', 'article_id' => 'desc'])
                    ->paginate(5, false, $query);
        // 获取分页导航
        $pageNav = $pageList->render();

        return ['pageList' => $pageList, 'pageNav' => $pageNav];
    }

    /**
     * 文章排序
     * @access public
     * @param array $data 排序数据
     * @return bool
     * @throws Exception
     */
    public function articleSort($data)
    {
        // 批量更新
        $result = $this->validate('article.sort')->saveAll($data);
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
        $result = $this->validate('Article.setStatus')
                  ->save($data, ['article_id' => $data['article_id']]);
        if($result === false) {
            throw new Exception('更新状态出错');
        }

        return true;
    }

    /**
     * 文章添加
     * @access public
     * @param array $data 添加数据
     * @return bool
     * @throws Exception
     */
    public function articleAdd($data)
    {
        // 往article表插入记录
        $result = $this->validate('Article.addArticle')
                  ->allowField(['title', 'subtitle', 'thumb', 'column_id', 'source', 'description', 'keywords', 'admin'])
                  ->save($data);
        if($result === false) {
            throw new Exception('文章添加出错');
        }

        // 获取article表自增id
        $article_id = $this->getAttr('article_id');

        // 往article_content表插入记录
        $addRes = $this->validate('Article.addContent')
                  ->allowField(['article_id,content'])
                  ->articleContent()
                  ->save(['article_id' => $article_id, 'content' => $data['content']]);
        if($addRes === false) {
            throw new Exception('文章内容添加出错');
        }

        return true;
    }

    /**
     * 文章更新
     * @access public
     * @param array $data 更新数据
     * @return bool
     * @throws Exception
     */
    public function articleUpdate($data)
    {
        // 更新文章
        $result = $this->validate('Article.saveArticle')
                  ->allowField(['title', 'subtitle', 'thumb', 'column_id', 'source', 'description', 'keywords', 'admin', 'article_id'])
                  ->save($data, ['article_id' => $data['article_id']]);
        if($result === false) {
            throw new Exception('文章更新出错');
        }

        // 更新文章内容
        $updateRes = $this->validate('Article.saveContent')
                     ->article_content
                     ->save(['content' => $data['content']], ['article_id' => $data['article_id']]);
        if($updateRes === false) {
            throw new Exception('文章内容更新出错');
        }

        return true;
    }
}
