<?php if(!empty($this->session)){
	if($this->session->flashdata('msg')){
		echo "<div class='alert alert-success' role='alert'>" . $this->session->flashdata('msg') . "</div>";
	}
}
?>

<h2><?php echo $title; ?></h2>

<p><a href="<?php echo site_url('news/create'); ?>">Agregar Noticia</a></p>

<table class="table table-striped">
	<thead class="thead-dark"><th scope="col">ID</th><th scope="col">Titulo</th><th scope="col">Texto</th><th scope="col">Acciones</th></thead>
	<tbody>

<?php foreach ($news as $news_item): ?>

        <tr>
        	<th scope="row"><?php echo $news_item['id']; ?></th>
        	<td><?php echo $news_item['title']; ?></td>
        	<td><?php echo $news_item['text']; ?></td>
			<td>
			     <p><a href="<?php echo site_url('news/edit/' . $news_item['id']); ?>">Editar</a></p>
			     <p><a href="<?php echo site_url('news/delete/' . $news_item['id']); ?>">Eliminar</a></p>
			</td>
		</tr>

<?php endforeach; ?>

</tbody>
</table>