<div class="row-actions">
	<span class="edit">
		<a href="<?= get_edit_post_link( $post->ID ) ?>" aria-label="Edit client">Edit</a> | 
	</span>
	<span class="trash">
		<a href="<?= get_delete_post_link( $post->ID, '', true ) ?>" class="submitdelete" aria-label="Move client to the Trash">Trash</a>
	</span>
</div>