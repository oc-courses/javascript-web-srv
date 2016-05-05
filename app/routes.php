<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

// Display all articles
$app->get('/articles', function() use ($app) {
    $articles = getArticles($app);
    return $app['twig']->render('articles.html.twig', array('articles' => $articles));
})->bind('articles');

// Add an article from form data
$app->post('/article', function(Request $request) use ($app) {
    $articleId = addArticle($request, $app);
    return $app->redirect($app['url_generator']->generate('articles'));
});

// Return all articles in JSON format
$app->get('/api/articles', function() use ($app) {
    $articles = getArticles($app);
    return $app->json($articles);
});

// Add an article from JSON data
$app->post('/api/article', function(Request $request) use ($app) {
    $articleId = addArticle($request, $app);
    return $app->json($articleId, 201);  // 201 = Created
});

// Return words starting with a particular letter in JSON format
// Handles only "A", "B" and "C" letters
$app->get('/api/lexique/{letter}', function ($letter, Request $request) use ($app) {
    $words = array();
    switch($letter) {
        case "A":
        array_push($words, array(
            'term' => 'Acronyme',
            'definition' => 'Sigle qui se prononce comme un mot ordinaire, sans épeler les lettres'));
        array_push($words, array(
            'term' => 'Asymptote',
            'definition' => 'Droite, cercle ou point dont une courbe plus complexe peut se rapprocher'));
        break;
        case "B":
        array_push($words, array(
            'term' => 'Biopsie',
            'definition' => "Prélèvement d'une très petite partie d'un organe ou d'un tissu pour effectuer des examens"));
        array_push($words, array(
            'term' => 'Botulisme',
            'definition' => 'Maladie paralytique rare mais grave due à une neurotoxine bactérienne, la toxine botulique'));
        break;
        case "C":
        array_push($words, array(
            'term' => 'Cacochyme',
            'definition' => "En état d’extrême faiblesse due à la vieillesse"));
        array_push($words, array(
            'term' => 'Cuticule',
            'definition' => "Couche externe qui recouvre et protège les organes aériens des végétaux et les organes de certains animaux"));
        break;
    }
    return $app->json($words);
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
