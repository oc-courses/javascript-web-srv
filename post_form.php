<?php
$post = print_r($_POST, true);
file_put_contents("post_form.log", $post);
