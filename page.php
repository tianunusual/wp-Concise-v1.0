<?php get_header(); ?>
<main id="wrapper">	
	<div class="inner">		
		<div id="main">
<?php while ( have_posts() ) : the_post(); ?>
<article class="box" id="article">	
		<h1 id="postTitle"><?php the_title(); ?></h1>
				<div class="entry">			
					<?php the_content(); ?>
				</div>
</article><?php endwhile; ?>
<?php if ( comments_open() || get_comments_number() ) :comments_template();endif;?>
        </div>	
        <?php get_sidebar();?>	
    </div>
</main>
<?php get_footer(); ?>