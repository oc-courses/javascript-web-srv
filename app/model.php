<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

// Return an array containing all articles
function getArticles(Application $app) {
    $sql = "select art_id as id, art_title as title, art_content as content from article order by art_id desc";
    return $app['db']->fetchAll($sql);
}

function addArticle(Request $request, Application $app) {
    // Check request parameters
    if (!$request->request->has('title')) {
        return $app->json('Missing required parameter: title', 400);
    }
    if (!$request->request->has('content')) {
        return $app->json('Missing required parameter: content', 400);
    }
    $title = $request->request->get('title');
    $content = $request->request->get('content');
    // Save the new article
    $app['db']->insert('article', array('art_title' => $title,
        'art_content' => $content));
    // Return the id of the newly inserted article
    return $app['db']->lastInsertId();
}
