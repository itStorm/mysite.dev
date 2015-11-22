<?php
namespace app\commands;

use app\modules\article\models\Article;
use common\libs\safedata\SafeDataFinder;
use yii\console\Controller;
use yii\helpers\Url;
use app\modules\article\controllers\DefaultController as ArticleController;

/**
 * Class SitemapController
 * @package app\commands
 */
class SitemapController extends Controller
{
    const CHANGEFREG_ALWAYS = 'always';
    const CHANGEFREG_HOURLY = 'hourly';
    const CHANGEFREG_DAILY = 'daily';
    const CHANGEFREG_WEEKLY = 'weekly';
    const CHANGEFREG_MONTHLY = 'monthly';
    const CHANGEFREG_YEARLY = 'yearly';
    const CHANGEFREG_NEVER = 'never';


    protected $webPath;

    /** @var string */
    protected $sitemapFilename = 'sitemap.xml';
    /** @var string */
    protected $sitemapFilenameNew = 'sitemap.xml.new';
    /** @var string */
    protected $sitemapFilePath;
    /** @var string */
    protected $sitemapFilenameNewPath;


    protected $sitemapData = [];

    /** @inheritdoc */
    public function init()
    {
        parent::init();
        $this->sitemapFilePath = \Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $this->sitemapFilename;
        $this->sitemapFilenameNewPath = \Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $this->sitemapFilenameNew;
    }

    /**
     * Генерация sitemap.xml - php yii sitemap
     */
    public function actionIndex()
    {
        $this->pushItem(
            Url::to('/', true),
            \Yii::$app->formatter->asDate(time(), 'php:Y-m-d'),
            self::CHANGEFREG_DAILY,
            '1.0'
        );

        $this->pushItem(
            Url::to([ArticleController::URL_PATH_INDEX], true),
            \Yii::$app->formatter->asDate(time(), 'php:Y-m-d'),
            self::CHANGEFREG_DAILY,
            '1.0'
        );

        /** COLLECT ARTICLES */

        /** @var Article[] $articles */
        $articles = Article::findAll([
            SafeDataFinder::FIELD_IS_ENABLED => SafeDataFinder::IS_ENABLED,
            SafeDataFinder::FIELD_IS_DELETED => SafeDataFinder::NOT_DELETED,
        ]);

        foreach ($articles as $article) {
            $this->pushItem(
                $article->getUrlView(true),
                \Yii::$app->formatter->asDate($article->updated, 'php:Y-m-d'),
                self::CHANGEFREG_WEEKLY,
                '1.0'
            );
        }
        /** END COLLECT ARTICLES */

        // Непосредственно генерация карты
        $writer = new \XMLWriter();
        $writer->openURI($this->sitemapFilenameNewPath);
        $writer->startDocument('1.0', 'UTF-8');
        $writer->startElement('urlset');
        $writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');

        foreach ($this->sitemapData as $item) {
            $writer->startElement('url');

            $writer->writeElement('loc', $item['loc']);
            $writer->writeElement('lastmod', $item['lastmod']);
            $writer->writeElement('changefreq', $item['changefreq']);
            $writer->writeElement('priority', $item['priority']);

            $writer->endElement();
        }

        $writer->endElement();
        $writer->endDocument();
        $writer->flush();

        if (file_exists($this->sitemapFilePath)) {
            unlink($this->sitemapFilePath);
        }
        rename($this->sitemapFilenameNewPath, $this->sitemapFilePath);
    }

    /**
     * Добавить новый элемент в карту
     * @param string $loc
     * @param string $lastmod
     * @param string $changefreq
     * @param string $priority
     */
    protected function pushItem($loc, $lastmod, $changefreq, $priority)
    {
        $this->sitemapData[] = [
            'loc'        => $loc,
            'lastmod'    => $lastmod,
            'changefreq' => $changefreq,
            'priority'   => $priority
        ];
    }
}
