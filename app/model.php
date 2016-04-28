<?php

function getArticles($app) {
    $sql = "select art_id as id, art_title as titre, art_content as contenu from article order by art_id desc";
    return $app['db']->fetchAll($sql);
}
