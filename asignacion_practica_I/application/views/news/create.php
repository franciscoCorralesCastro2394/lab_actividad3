<h2><?php echo $title; ?></h2>
<p><a href="<?php echo site_url('news'); ?>">Regresar a la Lista</a></p>

<?php echo validation_errors(); ?>

<div class="container-fluid form-group">

	<?php echo form_open('news/create'); ?>

	    <label for="title">Title</label>
	    <input class="form-control" type="input" name="title" /><br />

	    <label for="text">Text</label>
	    <textarea class="form-control" name="text"></textarea><br />

	    <input class="btn btn-success" type="submit" name="submit" value="Agregar Noticia" />

	</form>

</div>