<?php

if ($the_query->have_posts()): ?>

    <?php require_once("form-search.php"); ?>

    <?php wp_reset_postdata();
else:
    echo "Nenhum post encontrado";
endif;
?>