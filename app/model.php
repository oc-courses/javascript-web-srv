<?php

// Return an array containing all articles
function getArticles($app) {
    $sql = "select art_id as id, art_title as title, art_content as content from article order by art_id desc";
    return $app['db']->fetchAll($sql);
}

function insertArticle($title, $content, $app) {
    // $sql = "insert into article(art_title, art_content) values (?, ?)";
    $app['db']->insert('article', array('art_title' => $title,
        'art_content' => $content));
}
