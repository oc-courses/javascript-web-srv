<?php

use Symfony\Component\HttpFoundation\Request;

// Display all articles
$app->get('/articles', function() use ($app) {
    $articles = getArticles($app);
    return $app['twig']->render('articles.html.twig', array('articles' => $articles));
})->bind('articles');

// Return all articles in JSON format
$app->get('/api/articles', function() use ($app) {
    $articles = getArticles($app);
    return $app->json($articles);
});

// Return all articles in JSON format
$app->post('/api/article', function(Request $request) use ($app) {
    // Check request parameters
    if (!$request->request->has('title')) {
        return $app->json('Missing required parameter: title', 400);
    }
    if (!$request->request->has('content')) {
        return $app->json('Missing required parameter: content', 400);
    }
    // Save the new article
    insertArticle($request->request->get('title'), $request->request->get('content'), $app);
    return $app->json(null, 201);  // 201 = Created
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
