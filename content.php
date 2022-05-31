     <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
			<article class="blogItem">
		<figure class="thumbnail">
			<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><img src="<?php post_thumbnail_src(); ?>" alt="<?php the_title(); ?>"></a>
		</figure>
        <div class="text">
			<h2 class="title">
				<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h2>		
			<div class="rows excerpt">
				<p><?php if (post_password_required()):the_content(); else :  ?><?php if(has_excerpt()) the_excerpt();else echo '', mb_strimwidth(strip_tags($post->post_content),0,240,"...",'utf-8');endif; ?></p>
			</div>
			<div class="meta">
				<span class="date"><time pubdate="<?php the_time('Y-m-d'); ?>"><?php the_time('Y-m-d'); ?></time></span>
				<span class="cat"><?php the_category(','); ?></span>
				<span class="views"><?php echo post_views();?> 人围观过</span>
			</div>
</div><div class="clear"></div>
	</article>	
    <?php endwhile;else : ?><div style="padding:15px;background:#fff;text-align: center;"><h4 style="font-size:18px;font-weight:400;padding:20px 0;">很遗憾，没有找到符合条件的记录！</h4></div><?php endif;?>
    <div class="clear"></div>
    <?php if ( $wp_query->max_num_pages > 1 ) : ?><?php pagination($query_string); ?><?php endif; ?>