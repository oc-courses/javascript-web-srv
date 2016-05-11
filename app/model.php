<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

// Return an array containing last inserted articles
function getLastArticles(Application $app) {
    $sql = "select art_id as id, art_title as titre, art_content as contenu from article order by art_id desc limit 5";
    return $app['db']->fetchAll($sql);
}

// Save a new article into DB
function addArticle($title, $content, Application $app) {
    // Save the new article
    $app['db']->insert('article', array('art_title' => $title,
        'art_content' => $content));
    // Return the id of the newly inserted article
    return $app['db']->lastInsertId();
}

// Return an array containing all testimonials
function getTestimonials(Application $app) {
    $sql = "select test_id as id, test_nickname as pseudo, test_evaluation as evaluation,
        test_message as message from testimonial order by test_id desc";
    return $app['db']->fetchAll($sql);
}

// Save a new testimonial into DB
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

// Return words starting with a specific letter
// Handles only "A", "B" and "C" letters
function getWords($letter) {
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
    return $words;
}

// Return an array containing last inserted links
function getLastLinks(Application $app) {
    $sql = "select l.link_id as id, link_title as titre, link_url as url, link_author as auteur, count(com_id) as commentaires
        from link l left join comment c on l.link_id=c.link_id group by l.link_id order by l.link_id desc limit 5";
    return $app['db']->fetchAll($sql);
}

// Return comments for a specific link id
function getComments($linkId, Application $app) {
    $sql = "select * from comment where link_id=?";
    return $app['db']->fetchAssoc($sql, array($linkId));
}

// Save a new link into DB
function addLink($title, $url, $author, Application $app) {
    // Save the new link
    $app['db']->insert('link', array('link_title' => $title,
        'link_url' => $url,
        'link_author' => $author,
    ));
    // Return the id of the newly inserted link
    return $app['db']->lastInsertId();
}
