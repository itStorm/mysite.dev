<?php
namespace app\commands;

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
        // ..admin
        $auth->addChild($admin, $moderator);

        echo "Done!\n";
    }
}