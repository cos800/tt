<?php


namespace tt;


use think\facade\Request;
use think\paginator\driver\Bootstrap;

class PaginatorLayui extends Bootstrap
{
    /**
     * 渲染分页html
     * @return mixed
     */
    public function render()
    {
        if ($this->hasPages()) {
            if ($this->simple) {
                return sprintf(
                    '<div class="layui-box layui-laypage layui-laypage-default">%s %s</div>',
                    $this->getPreviousButton('上一页'),
                    $this->getNextButton('下一页')
                );
            } else {
                return sprintf(
                    '<div class="layui-box layui-laypage layui-laypage-default">%s %s %s</div>',
                    $this->getPreviousButton('上一页'),
                    $this->getLinks(),
                    $this->getNextButton('下一页')
                );
            }
        }
    }

    /**
     * 生成一个可点击的按钮
     *
     * @param  string $url
     * @param  string $page
     * @return string
     */
    protected function getAvailablePageWrapper(string $url, string $page): string
    {
        return <<<EOT
<a href="$url">$page</a>
EOT;
    }

    /**
     * 生成一个禁用的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getDisabledTextWrapper(string $text): string
    {
        return <<<EOT
<span class="layui-laypage-spr">$text</span>
EOT;
    }

    /**
     * 生成一个激活的按钮
     *
     * @param  string $text
     * @return string
     */
    protected function getActivePageWrapper(string $text): string
    {
        return <<<EOT
<span class="layui-laypage-curr"><em class="layui-laypage-em"></em><em>$text</em></span>
EOT;
    }

    /**
     * 获取页码对应的链接
     *
     * @access protected
     * @param int $page
     * @return string
     */
    protected function url(int $page): string
    {
        if ($page <= 0) {
            $page = 1;
        }

        $get = Request::get();
        unset($get['page']); // 为了把page参数放最后
        $get['page'] = $page;

        $url = Request::baseUrl().'?'.http_build_query($get);

        return $url;
    }
}