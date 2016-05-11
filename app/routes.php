<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

// ------- HTML routes -------

// Home page
$app->get('/', function() use ($app) {
    return $app['twig']->render('index.html.twig');
})->bind('home');

// Display last articles
$app->get('/articles', function() use ($app) {
    $articles = getLastArticles($app);
    return $app['twig']->render('articles.html.twig', array('articles' => $articles));
})->bind('articles');

// Add an article from form data
$app->post('/article', function(Request $request) use ($app) {
    // Check request parameters
    if (!$request->request->has('titre')) {
        return $app->json('Missing required parameter: titre', 400);
    }
    if (!$request->request->has('contenu')) {
        return $app->json('Missing required parameter: contenu', 400);
    }
    $title = $request->request->get('titre');
    $content = $request->request->get('contenu');
    // Add article into DB
    $articleId = addArticle($title, $content, $app);
    return $app->redirect($app['url_generator']->generate('articles'));
});

// Display all testimonials
$app->get('/temoignages', function() use ($app) {
    $testimonials = getTestimonials($app);
    return $app['twig']->render('testimonials.html.twig', array('testimonials' => $testimonials));
})->bind('testimonials');

// Display last links
$app->get('/liens', function() use ($app) {
    $links = getLastLinks($app);
    return $app['twig']->render('links.html.twig', array('links' => $links));
})->bind('links');

// ------- JSON API -------

// Return last articles in JSON format
$app->get('/api/articles', function() use ($app) {
    $articles = getLastArticles($app);
    return $app->json($articles);
});

// Add a testimonial from JSON data
$app->post('/api/temoignage', function(Request $request) use ($app) {
    $testimonialId = addTestimonial($request, $app);
    return $app->json($testimonialId, 201);  // 201 = Created
});

// Return words starting with a particular letter in JSON format
$app->get('/api/lexique/{letter}', function ($letter) use ($app) {
    $words = getWords($letter, $app);
    return $app->json($words);
});

// Return last links in JSON format
$app->get('/api/liens', function() use ($app) {
    $links = getLastLinks($app);
    return $app->json($links);
});

// Return comments for a specific link in JSON format
$app->get('/api/commentaires/{linkId}', function($linkId) use ($app) {
    $comments = getComments($linkId, $app);
    return $app->json($comments);
});

// Add a link from JSON data
$app->post('/api/lien', function(Request $request) use ($app) {
    // Check request parameters
    if (!$request->request->has('titre')) {
        return $app->json('Missing required parameter: titre', 400);
    }
    if (!$request->request->has('url')) {
        return $app->json('Missing required parameter: url', 400);
    }
    if (!$request->request->has('auteur')) {
        return $app->json('Missing required parameter: auteur', 400);
    }
    $title = $request->request->get('titre');
    $url = $request->request->get('url');
    $author = $request->request->get('auteur');
    // Add link into DB
    $linkId = addLink($title, $url, $author, $app);
    return $app->json($linkId, 201);  // 201 = Created
});
