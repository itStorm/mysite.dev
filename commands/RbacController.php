<?php
namespace app\commands;

use app\modules\banner\models\Banner;
use app\modules\banner\models\BannerArea;
use Yii;
use yii\console\Controller;
use app\modules\rbac\UserRoleRule;
use app\modules\article\models\Article;

class RbacController extends Controller
{
    public function actionInit()
    {
        // Актуализация прав php yii rbac/init
        echo "Generate rules...\n";

        $auth = Yii::$app->authManager;

        $auth->removeAll(); //удаляем старые данные

        // ARTICLES RULES
        $articleView = $auth->createPermission(Article::RULE_VIEW);
        $articleView->description = 'Article view';
        $auth->add($articleView);

        $articleCreate = $auth->createPermission(Article::RULE_CREATE);
        $articleCreate->description = 'Article create';
        $auth->add($articleCreate);

        $articleUpdate = $auth->createPermission(Article::RULE_UPDATE);
        $articleUpdate->description = 'Article update';
        $auth->add($articleUpdate);

        $articleFilesUpload = $auth->createPermission(Article::RULE_UPLOAD_FILES);
        $articleFilesUpload->description = 'Article upload files';
        $auth->add($articleFilesUpload);

        // BANNER AREAS RULES
        $bannerAreaView = $auth->createPermission(BannerArea::RULE_VIEW);
        $bannerAreaView->description = 'Banner area view';
        $auth->add($bannerAreaView);

        $bannerAreaCreate = $auth->createPermission(BannerArea::RULE_CREATE);
        $bannerAreaCreate->description = 'Banner area create';
        $auth->add($bannerAreaCreate);

        $bannerAreaUpdate = $auth->createPermission(BannerArea::RULE_UPDATE);
        $bannerAreaUpdate->description = 'Banner area update';
        $auth->add($bannerAreaUpdate);

        $bannerFilesUpload = $auth->createPermission(Banner::RULE_UPLOAD_FILES);
        $bannerFilesUpload->description = 'Banner upload files';
        $auth->add($bannerFilesUpload);

        // BANNERS RULES
        $bannerView = $auth->createPermission(Banner::RULE_VIEW);
        $bannerView->description = 'Banner view';
        $auth->add($bannerView);

        $bannerCreate = $auth->createPermission(Banner::RULE_CREATE);
        $bannerCreate->description = 'Banner create';
        $auth->add($bannerCreate);

        $bannerUpdate = $auth->createPermission(Banner::RULE_UPDATE);
        $bannerUpdate->description = 'Banner update';
        $auth->add($bannerUpdate);

        // Rule for checking roles
        $rule = new UserRoleRule();
        $auth->add($rule);

        // Create roles
        $user = $auth->createRole('user');
        $user->description = 'User';
        $user->ruleName = $rule->name;
        $auth->add($user);

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $moderator->ruleName = $rule->name;
        $auth->add($moderator);

        $admin = $auth->createRole('admin');
        $admin->description = 'Admin';
        $admin->ruleName = $rule->name;
        $auth->add($admin);

        // Set relations between different roles add permissions
        // ..user
        $auth->addChild($user, $articleView);
        // ..moderator
        $auth->addChild($moderator, $user);
        $auth->addChild($moderator, $articleCreate);
        $auth->addChild($moderator, $articleUpdate);
        $auth->addChild($moderator, $articleFilesUpload);
        $auth->addChild($moderator, $bannerView);
        $auth->addChild($moderator, $bannerAreaView);

        // ..admin
        $auth->addChild($admin, $moderator);
        $auth->addChild($admin, $bannerCreate);
        $auth->addChild($admin, $bannerUpdate);
        $auth->addChild($admin, $bannerFilesUpload);
        $auth->addChild($admin, $bannerAreaCreate);
        $auth->addChild($admin, $bannerAreaUpdate);

        echo "Done!\n";
    }
}