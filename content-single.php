<?php while ( have_posts() ) : the_post(); ?>
<article class="box" id="article">	
		<h1 id="postTitle"><?php the_title(); ?></h1>
				<div id="postmeta">
				<span class="date"><time pubdate="<?php the_time('Y-m-d'); ?>"><?php the_time('Y-m-d'); ?></time></span>
				<span class="cat"><?php the_category(','); ?></span>
				<span class="views"><?php echo post_views();?> 人围观过</span>
				</div>
				<div class="entry">			
					<?php the_content(); ?>
				</div>
				<div id="postTags"><?php the_tags('', ' ', ''); ?></div>	
	
	 <section class="view-tag">
          <hr class="wp-block-separator">
    <div id="postnavi">
                <section class="support-author">
</font>					<p><b><font face=华文行楷 color=red size=5><font color="ff0000">【</font><font color="#ff9900">版</font><font color="#ffcc00">权</font><font color="#66cc00">申</font><font color="#00ffcc">明</font><font color="#66ccff">】</font></b><br></font>
<font color="red">&nbsp;&nbsp;◉内容作者：</font> 本文内容以及文件均来自互联网搜集整理，文章内容并不代表本站观点。<br>
<font color="red">&nbsp;&nbsp;◉使用说明：</font> 浏览本站内容前您必须仔细阅读并同意<a href="../gov"  target="_blank">《免责申明》</a><br>
<font color="red">&nbsp;&nbsp;◉许可协议：</font><a href="https://creativecommons.org/licenses/by-nc-sa/2.5/cn/"  target="_blank">《署名-非商业性使用-相同方式共享 2.5 中国大陆 (CC BY-NC-SA 2.5 CN) 》</a></p>
         
        </section>
		 </div>
                <div id="postnavi">
						<div class="prev">
                        <?php if (get_previous_post()) { previous_post_link('# 上一篇： %link');} else {echo "# 上一篇：<a>已经是最后文章</a>";} ?>
						</div>				
                        <div class="next">
                        <?php if (get_next_post()) { next_post_link('# 下一篇： %link');} else {echo "# 下一篇：<a>已经是最新文章</a>";} ?>
                        </div>
				</div>

	<section id="recommend">
					<h3 class="hTitle">相关推荐：</h3>
					<ul>
<?php
$backup = $post;
$tags = wp_get_post_tags($post->ID);
$tagIDs = array();
if ($tags) {
$tagcount = count($tags);
for ($i = 0; $i < $tagcount; $i++) {
$tagIDs[$i] = $tags[$i]->term_id;
}
$args=array(
'tag__in' => $tagIDs,
'post__not_in' => array($post->ID),
'showposts'=>6, // 显示相关日志篇数 
'caller_get_posts'=>1
);
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
while ($my_query->have_posts()) : $my_query->the_post(); ?>
						<li>
							<div class="text">
								<h4 class="rows">
									<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h4>
						</li>
<?php endwhile;
} else { ?>
<?php
query_posts(array('orderby' => 'rand', 'showposts' => 6)); //显示随机日志篇数
if (have_posts()) :
while (have_posts()) : the_post();?>
						<li>
							<div class="text">
								<h4 class="rows">
									<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
								</h4>
						</li>
<?php endwhile;endif; ?>
<?php }
}
$post = $backup;
wp_reset_query();
?>

					</ul>
				</section>
</article><?php endwhile; ?>
<?php if ( comments_open() || get_comments_number() ) :comments_template();endif;?>
