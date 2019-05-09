<?php
include_once 'shared/web.php';

global $utopia, $response, $request, $layout, $version, $providers;

use Utopia\View;
use Utopia\Locale\Locale;

$utopia->init(function () use ($layout, $utopia) {
    $layout
        ->setParam('analytics', 'UA-26264668-5')
    ;
});

$utopia->shutdown(function() use ($utopia, $response, $request, $layout, $version) {
    $header = new View('../app/views/console/comps/header.phtml');
    $footer = new View('../app/views/console/comps/footer.phtml');

    $layout
        ->setParam('header', [$header])
        ->setParam('footer', [$footer])
        ->setParam('prefetch', [
            //'/console/database?version=' . $version,
            //'/console/storage?version=' . $version,
            //'/console/users?version=' . $version,
            //'/console/settings?version=' . $version,
            //'/console/account?version=' . $version,
        ])
    ;

    $response->send($layout->render());
});

$utopia->get('/error/:code')
    ->desc('Error page')
    ->label('permission', 'public')
    ->label('scope', 'home')
    ->param('code', null, new \Utopia\Validator\Numeric(), 'Valid status code number', false)
    ->action(function($code) use ($layout)
    {
        $page = new View('../app/views/error.phtml');

        $page
            ->setParam('code', $code)
        ;

        $layout
            ->setParam('title', APP_NAME . ' - Error')
            ->setParam('body', $page);
    });

$utopia->get('/console')
    ->label('permission', 'public')
    ->label('scope', 'console')
    ->action(function() use ($layout)
    {
        $page = new View('../app/views/console/index.phtml');

        $layout
            ->setParam('title', APP_NAME . ' - ' . Locale::getText('console.title'))
            ->setParam('body', $page);
    });

$utopia->get('/console/account')
    ->label('permission', 'public')
    ->label('scope', 'console')
    ->action(function() use ($layout)
    {
        $page = new View('../app/views/console/account/index.phtml');

        $cc = new View('../app/views/console/forms/credit-card.phtml');

        $page
            ->setParam('cc', $cc)
        ;

        $layout
            ->setParam('title', APP_NAME . ' - ' . Locale::getText('console.account.title'))
            ->setParam('body', $page);
    });

$utopia->get('/console/notifications')
    ->desc('Platform console notifications')
    ->label('permission', 'public')
    ->label('scope', 'console')
    ->action(function() use ($layout)
    {
        $page = new View('../app/views/v1/console/notifications/index.phtml');

        $layout
            ->setParam('title', APP_NAME . ' - ' . Locale::getText('console.notifications.title'))
            ->setParam('body', $page);
    });

$utopia->get('/console/home')
    ->desc('Platform console project home')
    ->label('permission', 'public')
    ->label('scope', 'console')
    ->action(function() use ($layout)
    {
        $page = new View('../app/views/console/home/index.phtml');

        $layout
            ->setParam('title', APP_NAME . ' - ' . Locale::getText('console.home.title'))
            ->setParam('body', $page);
    });

$utopia->get('/console/platforms/web')
    ->desc('Platform console project home')
    ->label('permission', 'public')
    ->label('scope', 'console')
    ->action(function() use ($layout)
    {
        $page = new View('../app/views/console/platforms/web.phtml');

        $layout
            ->setParam('title', APP_NAME . ' - ' . Locale::getText('console.home.title'))
            ->setParam('body', $page);
    });

$utopia->get('/console/settings')
    ->desc('Platform console project settings')
    ->label('permission', 'public')
    ->label('scope', 'console')
    ->action(function() use ($layout)
    {
        $page = new View('../app/views/console/settings/index.phtml');

        $layout
            ->setParam('title', APP_NAME . ' - ' . Locale::getText('console.settings.title'))
            ->setParam('body', $page);
    });

$utopia->get('/console/database')
    ->desc('Platform console project settings')
    ->label('permission', 'public')
    ->label('scope', 'console')
    ->action(function() use ($layout)
    {
        $page = new View('../app/views/console/database/index.phtml');

        $layout
            ->setParam('title', APP_NAME . ' - ' . Locale::getText('console.database.title'))
            ->setParam('body', $page);
    });

$utopia->get('/console/storage')
    ->desc('Platform console project settings')
    ->label('permission', 'public')
    ->label('scope', 'console')
    ->action(function() use ($layout)
    {
        $page = new View('../app/views/console/storage/index.phtml');

        $layout
            ->setParam('title', APP_NAME . ' - ' . Locale::getText('console.storage.title'))
            ->setParam('body', $page);
    });

$utopia->get('/console/users')
    ->desc('Platform console project settings')
    ->label('permission', 'public')
    ->label('scope', 'console')
    ->action(function() use ($layout, $providers)
    {
        $page = new View('../app/views/console/users/index.phtml');

        $page->setParam('providers', $providers);

        $layout
            ->setParam('title', APP_NAME . ' - ' . Locale::getText('console.users.title'))
            ->setParam('body', $page);
    });

$utopia->get('/console/users/view')
    ->desc('Platform console project user')
    ->label('permission', 'public')
    ->label('scope', 'console')
    ->action(function() use ($layout, $providers)
    {
        $page = new View('../app/views/console/users/view.phtml');

        $layout
            ->setParam('title', APP_NAME . ' - ' . Locale::getText('console.users.title'))
            ->setParam('body', $page);
    });