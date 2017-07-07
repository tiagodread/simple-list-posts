<?php 

if ( $the_query->have_posts() ): ?>

<form method="POST" id="search" name="searchPost">
	<label>Procurar:</label>
	<input type="text" id="procurar" name="procurar"></input>
	<button type="submit" class="btn btn-primary">Enviar</button>
</form>

<table class="table">
	<tr>
		<th>Postagem</th>
		<th>Conteudo</th></tr>
		<?php
		while ( $the_query->have_posts() ):
			$the_query->the_post();
		?>
		<tr><td><?php echo get_the_title(); ?> </td>
			<td><?php echo get_the_content(); ?></td></tr>
		<?php endwhile; ?>

	</table>
	<?php 	wp_reset_postdata();
	else:
		echo "Nenhum post encontrado";
	endif;
	?>