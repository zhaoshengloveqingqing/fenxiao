<div id="mainss" class="main" style="height:auto; padding-top:1px;">
<style type="text/css">
	table td li{ position:relative; margin-right:10px; cursor:pointer; width:251px; height:495px; float:left;overflow:hidden; margin-bottom:10px}
	table td li p{ padding:0px; margin:0px; display:none}
	table td li .bgs{ width:200px; height:24px; line-height:24px; position:absolute; top:1px; left:1px; z-index:1;background:#ccc;filter:alpha(opacity=70); -moz-opacity:0.7; -khtml-opacity:0.7;opacity:0.7;}
	table td li .font{ text-align:center; font-size:14px; color:#FFF; width:200px;height:24px; line-height:24px; position:absolute; top:1px; left:1px; z-index:2}
</style>
<div class="contentbox">
     <table cellspacing="2" cellpadding="5" width="100%">
	 <tr>
		<th align="left">模板选择</th>
	</tr>
	
	 <tr>
	 	<td align="left" valign="top">
		<ul>
				<?php foreach($arr as $k=>$row){?>
					<li id="<?php echo $k;?>" style="background:url(<?php echo $row['img'];?>) center top no-repeat">
						<p class="bgs"></p>
						<p class="font"><?php echo $k==$thismubanid ? '当前选择模板' : '点击选择模版';?></p>
					</li>
				<?php } ?>
			</ul>
		</td>
	 </tr>
	 </table>
	 </div>
</div>
<?php  $thisurl = ADMIN_URL.'muban.php'; ?>
<script type="text/javascript">
  $("td li").hover(
	  function () {
		$(this).find('p').show();
	  },
	  function () {
		$(this).find('p').hide();
	  }
	);
	
   	$('td li').live('click',function(){
		id = $(this).attr('id'); 
		obj = $(this);
		$.post('<?php echo $thisurl;?>',{action:'ajax_save_muban',id:id},function(data){
			$(obj).find('.font').html(data);
		});
	});
</script>
<div id="msg_win" style="display:none;top:490px;visibility:visible;opacity:1;">
	<div class="icos"><a id="msg_min" title="最小化" href="javascript:void 0">_</a><a id="msg_close" title="关闭" href="javascript:void 0">×</a></div>
	<div id="msg_title">提醒系统</div>
	<div id="msg_content"><a href="<?php echo ADMIN_URL; ?>/goods_order.php?type=list">你有新订单(*^__^*)<br />马上查看</a></div>
</div>
<div class="bgsound"></div>
<script language="javascript" type="text/javascript">
	var admin_url = '<?php echo ADMIN_URL; ?>';
</script> 
<script type="text/javascript" src="<?php echo ADMIN_URL; ?>/js/order_remind.js"></script> 
<script language="javascript" type="text/javascript">
//根据屏幕的高度决定左侧菜单的高度
changesize();
function changesize(){ 	
	// 获取窗口高度 
	if (window.innerHeight) 
	winHeight = window.innerHeight; 
	else if ((document.body) && (document.body.clientHeight)) 
	winHeight = document.body.clientHeight; 
	// 通过深入 Document 内部对 body 进行检测，获取窗口大小 
	if (document.documentElement && document.documentElement.clientHeight && document.documentElement.clientWidth) 
	{ 
	winHeight = document.documentElement.clientHeight; 
	} 
	}
	document.getElementById('mainss').style.height=(winHeight-10)+"px";
</script>