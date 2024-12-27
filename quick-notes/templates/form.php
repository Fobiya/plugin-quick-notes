<?php
$args = array(
    'post_type'      => 'quick_note',
    'post_status'    => 'publish',
    'author'         => get_current_user_id(),
    'posts_per_page' => -1,
    'orderby'        => 'date',
    'order'          => 'DESC',
);
$notes_query = new WP_Query( $args );
?>

<div id="quick-notes" class="p-4 bg-gray-100 rounded-lg shadow-md">
    <form id="quick-notes-form" class="mb-4">
        <input type="text" id="quick-notes-title" name="title" placeholder="<?php _e( 'Title', 'quick-notes' ); ?>" required class="w-full p-2 mb-2 border border-gray-300 rounded">
        <textarea id="quick-notes-content" name="content" placeholder="<?php _e( 'Content', 'quick-notes' ); ?>" required class="w-full p-2 mb-2 border border-gray-300 rounded"></textarea>
        <button type="submit" class="w-full p-2 bg-blue-500 text-white rounded hover:bg-blue-700"><?php _e( 'Add Note', 'quick-notes' ); ?></button>
    </form>
    <hr>

    <ul class="quick-notes-list space-y-2">
        <?php if ( $notes_query->have_posts() ) : ?>
            <?php while ( $notes_query->have_posts() ) : $notes_query->the_post(); ?>
                <li class="note-item p-4 bg-white border border-gray-300 rounded shadow-sm flex justify-between items-center">
                    <div class="note-content flex-grow">
                        <strong class="block text-lg"><?php the_title(); ?></strong>
                        <p class="text-gray-700"><?php the_content(); ?></p>
                        <p class="text-sm text-gray-500"><?php _e( 'Author:', 'quick-notes' ); ?> <?php the_author(); ?></p>
                    </div>
                    <button class="delete-note ml-2 p-2 bg-red-500 text-white rounded hover:bg-red-700" data-id="<?php the_ID(); ?>"><?php _e( 'Delete', 'quick-notes' ); ?></button>
                </li>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <li class="p-4 bg-white border border-gray-300 rounded shadow-sm"><?php _e( 'No notes found.', 'quick-notes' ); ?></li>
        <?php endif; ?>
    </ul>
</div>