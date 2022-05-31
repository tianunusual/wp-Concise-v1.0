<?php
class bigfa_widget extends WP_Widget {
    function bigfa_widget() {
        $widget_ops = array('description' => '以标题的形式列出一个月内评论最多的文章');
        $this->WP_Widget('popular', '热门文章', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']) ? strip_tags($instance['limit']) : 5;
        $limits = strip_tags($instance['limits']);
        echo $before_widget;
		if($title){ 
		echo $before_title.''.$title.$after_title;
		}?>
        <ul>
            <?php global $post; query_posts( array('date_query' => array(
                array(
                    'after'  => '1 month ago',
                ),
            ),'showposts' => $limit,'orderby' => 'comment_count','ignore_sticky_posts' => 1));?>
            <?php $numbers = range (1,15);shuffle($numbers);$result = array_slice($numbers,1,$limit);$i=0;while (have_posts()) : the_post(); ?>
<li>
				<h4 class="rows">
					<a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h4>
			</li>
                <?php $i++;endwhile;wp_reset_query(); ?>
        </ul>

        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['limit'] = strip_tags($new_instance['limit']);
        $instance['limits'] = strip_tags($new_instance['limits']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title' => '', 'limit' => ''));
        $title = esc_attr($instance['title']);
        $limit = strip_tags($instance['limit']);
        $limits = strip_tags($instance['limits']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">文章数量：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
        </p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }
}
add_action('widgets_init', 'bigfa_widget_init');
function bigfa_widget_init() {
    register_widget('bigfa_widget');
}

class  bigfa_widget2 extends WP_Widget {
    function bigfa_widget2() {
        $widget_ops = array('description' => '站内搜索');
        $this->WP_Widget('search', '站内搜索', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
		$title = apply_filters('title',esc_attr($instance['title']));
		$limits = strip_tags($instance['limits']);
        echo $before_widget;
		if($title){ 
		echo $before_title.''.$title.$after_title;
		}?>
    <form name="search" method="get" action="<?php bloginfo('home'); ?>"><div class="input"><input type="text" class="text" name="s" size="11" /> <input type="submit" class="submit" value="" /></div></form>
        <?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['limits'] = strip_tags($new_instance['limits']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title' => '', 'limit' => ''));
        $title = esc_attr($instance['title']);
		$limits = strip_tags($instance['limits']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }
}
add_action('widgets_init', 'bigfa_widget2_init');
function bigfa_widget2_init() {
    register_widget('bigfa_widget2');
}

class bigfa_widget3 extends WP_Widget {
    function bigfa_widget3() {
        $widget_ops = array('description' => '列出站点最近的评论');
        $this->WP_Widget('rencent_comments', '最新评论', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']) ? strip_tags($instance['limit']) : 5;
	$limits = strip_tags($instance['limits']);$limits1 = strip_tags($instance['limits1']);
        ?>
        <div class="widget divComments"><?php if($title){ 
		echo $before_title.''.$title.$after_title;
		}?>
        <ul>
        <?php
		$show_comments = $number;
		$my_email = get_bloginfo ('admin_email');
		$i = 1;
		$comments = get_comments('number='.$limit.'&status=approve&type=comment');
		foreach ($comments as $my_comment) {
			if ($my_comment->comment_author_email != $my_email) {
				?>
				<li>
					<a href="<?php echo get_permalink($my_comment->comment_post_ID); ?>#anchor-comment-<?php echo $my_comment->comment_ID; ?>" title="<?php echo $my_comment->comment_author; ?>发表在《<?php echo get_the_title($my_comment->comment_post_ID); ?>上的评论" rel="external nofollow">
                    <?php echo get_avatar($my_comment->comment_author_email,64, '', $my_comment->comment_author); ?>
                    <div class="text"><span class="name"><?php echo $my_comment->comment_author; ?></span></div>
                    <div class="text"><?php echo convert_smilies($my_comment->comment_content); ?></div>
					</a>
				</li>
				<?php
				if ($i == $show_comments) break;
				$i++;
			}
		}
		?>
        </ul>

        <?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['limit'] = strip_tags($new_instance['limit']);
		$instance['limits'] = strip_tags($new_instance['limits']);$instance['limits1'] = strip_tags($new_instance['limits1']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => '', 'email' => ''));
        $title = esc_attr($instance['title']);
        $limit = strip_tags($instance['limit']);
		$limits = strip_tags($instance['limits']);$limits1 = strip_tags($instance['limits1']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">显示数量：(最好5个以下) <input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
        </p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }
}
add_action('widgets_init', 'bigfa_widget3_init');
function bigfa_widget3_init() {
    register_widget('bigfa_widget3');
}

class bigfa_widget6 extends WP_Widget {
    function bigfa_widget6() {
        $widget_ops = array('description' => '配合主题样式，字体大小统一');
        $this->WP_Widget('divTags', '标签云', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']);
        echo $before_widget;
		if($title){ 
		echo $before_title.''.$title.$after_title;
		}?>
        <ul class="wp-tag-cloud">
            <?php
              foreach (get_tags( array('number' =>$limit, 'orderby' => 'count','order' => 'DESC') ) as $tag){
        $tag_link = get_tag_link($tag->term_id);
        echo "<li><a href='{$tag_link}' title='{$tag->name}' class='{$tag->slug}'>{$tag->name}</a></li>";
        }
            ?>
        </ul>

        <?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['limit'] = strip_tags($new_instance['limit']);
		$instance['limits'] = strip_tags($new_instance['limits']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => ''));
        $title = esc_attr($instance['title']);
        $limit = strip_tags($instance['limit']);
		$limits = strip_tags($instance['limits']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">显示数量：<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
        </p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }
}
add_action('widgets_init', 'bigfa_widget6_init');
function bigfa_widget6_init() {
    register_widget('bigfa_widget6');
}

class bigfa_widget7 extends WP_Widget {
    function bigfa_widget7() {
        $widget_ops = array('description' => '双栏的分类目录，只支持一级目录');
        $this->WP_Widget('categories', '分类目录', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
	$limits = strip_tags($instance['limits']);
        echo $before_widget;
		if($title){ 
		echo $before_title.''.$title.$after_title;
		}?>
        <ul>
            <?php wp_list_categories( array(
                    'style' => 'list',
                    'show_count' => 0,
                    'title_li' => '',
                    'order' => 'ASC',
					'depth' => '-1',
                    'echo' => 1
                )
            );
            ?>
        </ul>

        <?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
	$instance['limits'] = strip_tags($new_instance['limits']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title'=> ''));
        $title = esc_attr($instance['title']);
	$limits = strip_tags($instance['limits']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }
}
add_action('widgets_init', 'bigfa_widget7_init');
function bigfa_widget7_init() {
    register_widget('bigfa_widget7');
}

class bigfa_widget9 extends WP_Widget {
    function bigfa_widget9() {
        $widget_ops = array('description' => '主题自带下拉式的文章归档小工具');
        $this->WP_Widget('archives', '文章归档', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limits = strip_tags($instance['limits']);
        echo $before_widget;
		if($title){ 
		echo $before_title.''.$title.$after_title;
		}?>
  <div style="padding:20px;"><select name="archive-dropdown" onChange='document.location.href=this.options[this.selectedIndex].value;'> 
  <option value=""><?php echo attribute_escape(__('Select Month')); ?></option> 
  <?php wp_get_archives('type=monthly&format=option&show_post_count=1'); ?> </select></div>
        <?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['limits'] = strip_tags($new_instance['limits']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
		$title = esc_attr($instance['title']);
		$limits = strip_tags($instance['limits']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }
}
add_action('widgets_init', 'bigfa_widget9_init');
function bigfa_widget9_init() {
    register_widget('bigfa_widget9');
}

class bigfa_widget10 extends WP_Widget {
    function bigfa_widget10() {
        $widget_ops = array('description' => '以标题排行的形式列出浏览阅读最多的文章');
        $this->WP_Widget('vivew', '浏览排行', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $strtotime = strip_tags($instance['strtotime']);
		$limit = strip_tags($instance['date']);
        $limits = strip_tags($instance['limits']);
        echo $before_widget;
		if($title){ 
		echo $before_title.''.$title.$after_title;
		}?>
        <ul>
<?php
global $wpdb, $post;
$output = '';
$most_viewed = $wpdb->get_results("SELECT DISTINCT $wpdb->posts.*, (meta_value+0) AS views FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE post_date > '".date('Y-m-d',strtotime('-'.$strtotime.'days'))."' AND post_type ='post' AND post_status = 'publish' AND meta_key = 'views' AND post_password = '' ORDER BY views DESC LIMIT $limit");//设置近100天内文章的排行榜
if($most_viewed) {
foreach ($most_viewed as $post) {
$output .= "\n<li>
				<h4 class=\"rows\">
					<a href=\"".get_permalink($post->ID)."\" title=\"".$post->post_title."\">".$post->post_title."</a>
				</h4>
			</li>";
}
echo $output;
}; ?>
        </ul>

        <?php
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['strtotime'] = strip_tags($new_instance['strtotime']);
		$instance['date'] = strip_tags($new_instance['date']);
		$instance['limits'] = strip_tags($new_instance['limits']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title' => '', 'limit' => ''));
        $title = esc_attr($instance['title']);
        $strtotime = strip_tags($instance['strtotime']);
		$date = strip_tags($instance['date']);
		$limits = strip_tags($instance['limits']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
       <p>
            <label for="<?php echo $this->get_field_id('strtotime'); ?>">统计时间：一周填7，一月填30，一季度填90<input class="widefat" id="<?php echo $this->get_field_id('strtotime'); ?>" name="<?php echo $this->get_field_name('strtotime'); ?>" type="text" value="<?php echo $strtotime; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('date'); ?>">文章数量：<input class="widefat" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="text" value="<?php echo $date; ?>" /></label>
        </p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }
}
add_action('widgets_init', 'bigfa_widget10_init');
function bigfa_widget10_init() {
    register_widget('bigfa_widget10');
}

function d_postlists() {
	register_widget( 'd_postlist' );
}

class d_postlist extends WP_Widget {
	function d_postlist() {
		$widget_ops = array( 'classname' => 'd_postlist', 'description' => '最新文章+热门文章+随机文章' );
		$this->WP_Widget( 'd_postlist', '聚合文章', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title        = apply_filters('widget_name', $instance['title']);
		$limit        = $instance['limit'];
		$limits       = $instance['limits'];
		$orderby      = $instance['orderby'];
        echo $before_widget;
		if($title){ 
		echo $before_title.''.$title.$after_title;
		}
		echo '<ul>';
		echo dtheme_posts_list( $orderby,$limit);
		echo '</ul>';
		echo $after_widget;
	}

	function form( $instance ) {
?>
		<p>
			<label>
				标题：
				<input style="width:100%;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</label>
		</p>
		<p>
			<label>
				排序：
				<select style="width:100%;" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" style="width:100%;">
					<option value="date" <?php selected('date', $instance['orderby']); ?>>发布时间</option>
					<option value="comment_count" <?php selected('comment_count', $instance['orderby']); ?>>评论排行</option>
					<option value="rand" <?php selected('rand', $instance['orderby']); ?>>随机</option>
				</select>
			</label>
		</p>
		<p>
			<label>
				显示数目：
				<input style="width:100%;" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="number" value="<?php echo $instance['limit']; ?>" size="24" />
			</label>
		</p>

	<?php
	}
}


function dtheme_posts_list($orderby,$limit) {
	$args = array(
		'order'            => 'DESC',
		'orderby'          => $orderby,
		'showposts'        => $limit,
		'caller_get_posts' => 1
	);
	global $post;
	query_posts($args);
	while (have_posts()) : the_post(); 
?>
<li>
				<h4 class="rows">
					<a target="_blank" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
				</h4>
			</li>
<?php
    endwhile; wp_reset_query();
}
add_action( 'widgets_init', 'd_postlists' );


class bigfa_widget15 extends WP_Widget {
    function bigfa_widget15() {
        $widget_ops = array('description' => '');
        $this->WP_Widget('adbox', '关于作者', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
		$pic1 = strip_tags($instance['pic1']);$pic2 = strip_tags($instance['pic2']);$pic3 = strip_tags($instance['pic3']);$pic4 = strip_tags($instance['pic4']);$pic5 = strip_tags($instance['pic5']);$pic6 = strip_tags($instance['pic6']);$pic7 = strip_tags($instance['pic7']);
		$limits = strip_tags($instance['limits']);
        ?>
 <section class="widget" id="divPersonal">	
 <div class="avatar">
			<img src="<?php if($pic3){echo $pic3;}else{?><?php bloginfo('template_url'); ?>/images/avatar.png<?php }?>" alt="<?php echo $title; ?>" width="124px" height="124px"/>
		</div>
		<div class="intro">
			<?php if($title){echo '<h3 class="name">'.$title.'</h3>';}?>	
			<div class="job">	
                <?php if($pic1){echo '<p>'.$pic1.'</p>';}?>	
                <?php if($pic2){echo '<p>'.$pic2.'</p>';}?>
			</div>
		</div>
		<div class="contact">
			<?php if($pic4){?><span><a rel="nofollow" class="qq" href="tencent://message/?Menu=yes&uin=<?php echo $pic4; ?>" title="QQ">
					<i>QQ</i>
				</a>
			</span><?php }?>
			<?php if($pic5){?><span>
				<a rel="nofollow" class="mail" href="mailto:<?php echo $pic5; ?>">
					<i>邮箱</i>
				</a>
			</span><?php }?>
		</div>
		<div class="meta">
			<ul>
				<li>
					<p>文章数</p>
					<p>
						<span><?php $count_posts = wp_count_posts();echo $published_posts = $count_posts->publish;?></span>
					</p>
				</li>
				<li>
					<p>阅读量</p>
					<p>
						<span><?php echo lo_all_view(); ?></span>
					</p>					
				</li>
			</ul>
		</div>	
        <?php
        echo $after_widget;
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['pic1'] = strip_tags($new_instance['pic1']);$instance['pic2'] = strip_tags($new_instance['pic2']);$instance['pic3'] = strip_tags($new_instance['pic3']);$instance['pic4'] = strip_tags($new_instance['pic4']);$instance['pic5'] = strip_tags($new_instance['pic5']);$instance['pic6'] = strip_tags($new_instance['pic6']);$instance['pic7'] = strip_tags($new_instance['pic7']);
        $instance['limits'] = strip_tags($new_instance['limits']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => ''));
        $title = esc_attr($instance['title']);
		$pic1 = strip_tags($instance['pic1']);$pic2 = strip_tags($instance['pic2']);$pic3 = strip_tags($instance['pic3']);$pic4 = strip_tags($instance['pic4']);$pic5 = strip_tags($instance['pic5']);$pic6 = strip_tags($instance['pic6']);$pic7 = strip_tags($instance['pic7']);
		$limits = strip_tags($instance['limits']);
        ?>
      <p>
            <label for="<?php echo $this->get_field_id('pic3'); ?>">头像地址<input class="widefat" id="<?php echo $this->get_field_id('pic3'); ?>" name="<?php echo $this->get_field_name('pic3'); ?>" type="text" value="<?php echo $pic3; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">作者名称<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
      <p>
            <label for="<?php echo $this->get_field_id('pic1'); ?>">工作类型<input class="widefat" id="<?php echo $this->get_field_id('pic1'); ?>" name="<?php echo $this->get_field_name('pic1'); ?>" type="text" value="<?php echo $pic1; ?>" /></label>
        </p>
      <p>
            <label for="<?php echo $this->get_field_id('pic2'); ?>">简单介绍<input class="widefat" id="<?php echo $this->get_field_id('pic2'); ?>" name="<?php echo $this->get_field_name('pic2'); ?>" type="text" value="<?php echo $pic2; ?>" /></label>
        </p>
      <p>
            <label for="<?php echo $this->get_field_id('pic4'); ?>">Q Q号码：<input class="widefat" id="<?php echo $this->get_field_id('pic4'); ?>" name="<?php echo $this->get_field_name('pic4'); ?>" type="text" value="<?php echo $pic4; ?>" /></label>
        </p>
      <p>
            <label for="<?php echo $this->get_field_id('pic5'); ?>">邮箱地址：<input class="widefat" id="<?php echo $this->get_field_id('pic5'); ?>" name="<?php echo $this->get_field_name('pic5'); ?>" type="text" value="<?php echo $pic5; ?>" /></label>
        </p>

        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }
}
add_action('widgets_init', 'bigfa_widget15_init');
function bigfa_widget15_init() {
    register_widget('bigfa_widget15');
}

class  bigfa_widget11 extends WP_Widget {
    function bigfa_widget11() {
        $widget_ops = array('description' => '双栏的友情链接，只支持一级目录');
        $this->WP_Widget('friend_links', '友情链接', $widget_ops);
    }
    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title',esc_attr($instance['title']));
        $limit = strip_tags($instance['limit']);
        $orderby = strip_tags($instance['orderby']);
        $cats = strip_tags($instance['cats']);
        ?>
        <?php if ( is_home()&&!is_paged() ) : ?>
        <section class="widget widget_links">
        <?php if($title){ 
		echo $before_title.''.$title.$after_title;
		}?>
        <ul class="widget_links">
            <?php wp_list_bookmarks( array(
                    'limit' => $limit,
                    'hide_empty' => 1,
                    'category'  => $cats,
                    'categorize' => 0,
                    'title_li' => '',
                    'orderby' => $orderby,
                    'order' => 'ASC',
                    'echo' => 1
                )
            );
            ?>
        </ul></section>
        <?php endif;?>
        <?php
    }
    function update($new_instance, $old_instance) {
        if (!isset($new_instance['submit'])) {
            return false;
        }
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['limit'] = strip_tags($new_instance['limit']);
        $instance['orderby'] = strip_tags($new_instance['orderby']);
        $instance['cats'] = strip_tags($new_instance['cats']);
        return $instance;
    }
    function form($instance) {
        global $wpdb;
        $instance = wp_parse_args((array) $instance, array('title'=> '', 'limit' => '-1', 'cats' => '', 'orderby' => 'name'));
        $title = esc_attr($instance['title']);
        $limit = strip_tags($instance['limit']);
        $orderby = strip_tags($instance['orderby']);
        $cats = strip_tags($instance['cats']);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">标题：<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">数量：默认"-1"为全部显示。<br>如果需要限时数量，输入具体数值<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('cats'); ?>">显示分类：<br>● 默认不填写即显示所有分类里的链接<br>● 填写某分类的ID，显示此分类下的链接<input class="widefat" id="<?php echo $this->get_field_id('cats'); ?>" name="<?php echo $this->get_field_name('cats'); ?>" type="text" value="<?php echo $cats; ?>" /></label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('orderby'); ?>">排序：<br>● 默认"name"按名称排列<br>● 如果需要其他排列，输入相应的排序形式。<a target="_blank" href="http://codex.wordpress.org/Function_Reference/wp_list_bookmarks">查看orderby排序参数</a><input class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" type="text" value="<?php echo $orderby; ?>" /></label>
        </p>
        <input type="hidden" id="<?php echo $this->get_field_id('submit'); ?>" name="<?php echo $this->get_field_name('submit'); ?>" value="1" />
    <?php
    }
}
add_action('widgets_init', 'bigfa_widget11_init');
function bigfa_widget11_init() {
    register_widget('bigfa_widget11');
}