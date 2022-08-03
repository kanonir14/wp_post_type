<?php get_header(); ?>

<h1>Объявления</h1>

<div class="ads-grid">
<?php 
      $args = array(
        'post_type' => 'ads',
        'posts_per_page' => 10
      );

    $query = new WP_Query( $args ); 
  ?>
  <?php if ( $query->have_posts() ) : ?>

    <?php while ( $query->have_posts() ) : $query->the_post(); ?>

    	<div class="item">
    		<div class="item-img">
    			<?php the_post_thumbnail(); ?>
    		</div>
    		<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
    	</div>

    <?php endwhile; ?>

    <?php wp_reset_postdata(); ?>

  <?php else : ?>
    <p><?php esc_html_e( 'Нет постов по вашим критериям.' ); ?></p>
  <?php endif; ?>

</div>

<?php get_footer(); ?>