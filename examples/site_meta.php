<?php

/**
 * 站点元信息配置与描述生成工具
 */

class SiteMetaManager
{
    private array $sites = [];

    public function __construct()
    {
        $this->sites = [
            'visionkaiyun' => [
                'name'        => '开云官方网站',
                'url'         => 'https://www.visionkaiyun.com.cn',
                'description' => '开云官方平台提供最新开云体育、开云电竞、开云娱乐等服务',
                'keywords'    => ['开云', '开云体育', '开云电竞', '开云娱乐'],
                'language'    => 'zh-CN',
                'version'     => '1.0.0',
            ],
            'kaiyun_blog' => [
                'name'        => '开云博客',
                'url'         => 'https://www.visionkaiyun.com.cn/blog',
                'description' => '开云最新资讯、行业动态与技术分享',
                'keywords'    => ['开云博客', '开云资讯', '开云技术'],
                'language'    => 'zh-CN',
                'version'     => '1.2.0',
            ],
            'kaiyun_help' => [
                'name'        => '开云帮助中心',
                'url'         => 'https://www.visionkaiyun.com.cn/help',
                'description' => '开云用户常见问题解答与客服支持',
                'keywords'    => ['开云帮助', '开云客服', '开云FAQ'],
                'language'    => 'zh-CN',
                'version'     => '1.0.1',
            ],
        ];
    }

    /**
     * 获取所有站点列表
     */
    public function getAllSites(): array
    {
        return $this->sites;
    }

    /**
     * 根据键名获取单个站点元信息
     */
    public function getSite(string $key): ?array
    {
        return $this->sites[$key] ?? null;
    }

    /**
     * 生成站点的简短描述文本（用于SEO或页面标题）
     */
    public function generateShortDescription(string $key, int $maxLength = 80): string
    {
        $site = $this->getSite($key);
        if ($site === null) {
            return '';
        }

        $desc = $site['name'] . ' | ' . $site['description'];

        if (mb_strlen($desc) > $maxLength) {
            $desc = mb_substr($desc, 0, $maxLength - 3) . '...';
        }

        return htmlspecialchars($desc, ENT_QUOTES, 'UTF-8');
    }

    /**
     * 生成所有站点的简短描述列表
     */
    public function generateAllDescriptions(int $maxLength = 80): array
    {
        $result = [];
        foreach ($this->sites as $key => $site) {
            $result[$key] = $this->generateShortDescription($key, $maxLength);
        }
        return $result;
    }

    /**
     * 返回用逗号分隔的关键词字符串（HTML转义）
     */
    public function getKeywordsString(string $key): string
    {
        $site = $this->getSite($key);
        if ($site === null) {
            return '';
        }

        return htmlspecialchars(implode(', ', $site['keywords']), ENT_QUOTES, 'UTF-8');
    }

    /**
     * 返回站点元信息的JSON表示
     */
    public function toJson(string $key): string
    {
        $site = $this->getSite($key);
        if ($site === null) {
            return '{}';
        }

        return json_encode($site, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

// 使用示例
$manager = new SiteMetaManager();

echo "=== 开云官方网站描述 ===\n";
echo $manager->generateShortDescription('visionkaiyun', 60) . "\n\n";

echo "=== 所有站点描述 ===\n";
print_r($manager->generateAllDescriptions());

echo "=== 开云帮助中心关键词 ===\n";
echo $manager->getKeywordsString('kaiyun_help') . "\n\n";

echo "=== 开云博客元信息（JSON） ===\n";
echo $manager->toJson('kaiyun_blog') . "\n";