<?php
/**
 * Template Name: 全宽页面
 */
get_header(); ?>
<main id="wrapper">	
	<div class="inner">		
<?php while ( have_posts() ) : the_post(); ?>
<article class="box" id="article">	
		<h1 id="postTitle"><?php the_title(); ?></h1>
				<div class="entry">			
					<?php the_content(); ?>
				</div>
</article><?php endwhile; ?>
    </div>
</main>
<?php get_footer(); ?>