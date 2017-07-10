<div class="panel panel-primary painel-seach">
    <!-- Default panel contents -->
    <div class="panel-heading">Procurar posts</div>
    <div class="panel-body">
        <form action="" method="post">
            <div class="form-group">
                <label for="procurar">Procurar:</label>
                <input type="text" class="form-control" id="procurar" name="procurar">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary" id="enviar" name="enviar">Enviar</button>
            </div>
        </form>
    </div>

    <table class="table">
        <tr>
            <th>Postagem</th>
            <th>Conteudo</th>
        </tr>
        <?php
        while ($the_query->have_posts()):
            $the_query->the_post();
            ?>
            <tr>
                <td><?php echo get_the_title(); ?> </td>
                <td><?php echo get_the_content(); ?></td>
            </tr>
        <?php endwhile; ?>

    </table>
</div>



