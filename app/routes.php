<?php

// Home page
$app->get('/articles', function() use ($app) {
    $articles = getArticles($app);
    return $app['twig']->render('articles.html.twig', array('articles' => $articles));
})->bind('articles');

$app->get('/api/articles', function() use ($app) {
    $articles = getArticles($app);
    return $app->json($articles);
});

$app->get('/api/liens', function() use ($app) {
    $sql = "select l.link_id as id, link_title as titre, link_url as url, link_author as auteur, count(com_id) as commentaires
        from link l left join comment c on l.link_id=c.link_id group by l.link_id order by l.link_id desc";
    $result = $app['db']->fetchAll($sql);

    return $app->json($result);
});

$app->get('/api/commentaires/{linkId}', function($linkId) use ($app) {
    $sql = "select * from comment where link_id=?";
    $result = $app['db']->fetchAssoc($sql, array($linkId));

    return $app->json($result);
});
