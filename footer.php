<div class="clear"></div>
<footer id="footer">
	<div class="inner">
		<?php if(get_option('logo')){?><div id="logoIcon">
			<div class="icon">
				<img src="<?php echo get_option('logo');?>" alt="<?php bloginfo('name'); ?>" width="63px" height="63px"/>
			</div>
		</div><?php }?>
		<div id="copyright">
			<p>

<!----底部版权开始---->
<span>Copyright &copy; &nbsp;2014-2022&nbsp;【<?php bloginfo('name'); ?>】 All rights reserved.
 &nbsp;| 主题：<a href="https://titti.cn/t-127.html" title="余笙" target="_blank">Concise v1.0</a>&nbsp;|&nbsp;
    勉强运行（<SPAN id=span_dt_dt style="color: #228B22;"></SPAN> <SCRIPT language=javascript>function show_date_time(){
    window.setTimeout("show_date_time()", 1000);
    BirthDay=new Date("1/01/2022 5:20:00");
    today=new Date();
    timeold=(today.getTime()-BirthDay.getTime());
    sectimeold=timeold/1000
    secondsold=Math.floor(sectimeold);
    msPerDay=24*60*60*1000
    e_daysold=timeold/msPerDay
    daysold=Math.floor(e_daysold);
    e_hrsold=(e_daysold-daysold)*24;
    hrsold=Math.floor(e_hrsold);
    e_minsold=(e_hrsold-hrsold)*60;
    minsold=Math.floor((e_hrsold-hrsold)*60);
    seconds=Math.floor((e_minsold-minsold)*60);
    span_dt_dt.innerHTML='<font style=color:#FF0000>'+daysold+'</font> 天 <font style=color:#FF0000>'+hrsold+'</font> 时 <font style=color:#FF0000>'+minsold+'</font> 分 <font style=color:#FF0000>'+seconds+'</font> 秒';
    }
    show_date_time();</script>）
<!----底部版权结束---->
    
    &nbsp;|&nbsp;<a href="https://titti.cn/whois.php" title="域名信息" target="_blank">Whois</a>&nbsp;|&nbsp;  
    
    <a target="_blank" title="51.la 网站统计" href="https://invite.51.la/1NJbgJxe?target=V6"><img src="https://sdk.51.la/icon/3-4.png"></a>
 <a target="_blank" title="51.la 灵雀监控" href="https://invite.51.la/1NJbgJxe?target=V6"><img src="https://perf.51.la//favicon.ico" width="18" height="18"></a>
	
			</p>
				
				
			<p class="beian">
				<?php echo get_option('analytics'); ?>
			</p>
		</div>
	   	<div id="back">
			<i></i>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
<html>
