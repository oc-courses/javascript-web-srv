<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

// Return an array containing last inserted articles
function getLastArticles(Application $app) {
    $sql = "select art_id as id, art_title as titre, art_content as contenu from article order by art_id desc limit 5";
    return $app['db']->fetchAll($sql);
}

// Saves a new article into DB
function addArticle(Request $request, Application $app) {
    // Check request parameters
    if (!$request->request->has('titre')) {
        return $app->json('Missing required parameter: titre', 400);
    }
    if (!$request->request->has('contenu')) {
        return $app->json('Missing required parameter: contenu', 400);
    }
    $title = $request->request->get('titre');
    $content = $request->request->get('contenu');
    // Save the new article
    $app['db']->insert('article', array('art_title' => $titre,
        'art_content' => $contenu));
    // Return the id of the newly inserted article
    return $app['db']->lastInsertId();
}

// Return an array containing all testimonials
function getTestimonials(Application $app) {
    $sql = "select test_id as id, test_nickname as pseudo, test_evaluation as evaluation,
        test_message as message from testimonial order by test_id desc";
    return $app['db']->fetchAll($sql);
}

// Saves a new testimonial into DB
function addTestimonial(Request $request, Application $app) {
    // Check request parameters
    if (!$request->request->has('pseudo')) {
        return $app->json('Missing required parameter: pseudo', 400);
    }
    if (!$request->request->has('evaluation')) {
        return $app->json('Missing required parameter: evaluation', 400);
    }
    $pseudo = $request->request->get('pseudo');
    $evaluation = $request->request->get('evaluation');
    // Message is optional
    if ($request->request->has('message')) {
        $message = $request->request->get('message');
    }
    // Save the new testimonial
    $app['db']->insert('testimonial', array('test_nickname' => $pseudo,
        'test_evaluation' => $evaluation,
        'test_message' => $message,
    ));
    // Return the id of the newly inserted testimonial
    return $app['db']->lastInsertId();
}
