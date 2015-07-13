<div class="jjmain">
	<div class="jjmainbox">
	<div class="jjbanner">
			<!--banner-->
			<style type="text/css">
			/* qqshop focus */
			#focus {width:1020px; height:357px; overflow:hidden; position:relative;}
			#focus ul {height:380px; position:absolute;}
			#focus ul li {float:left; width:1020px; height:357px; overflow:hidden; position:relative; background:#000;}
			#focus ul li div {position:absolute; overflow:hidden;}
			#focus .btnBg {position:absolute; width:1020px; height:20px; left:0; bottom:0;}
			#focus .btn {position:absolute; width:1000px; height:10px; padding:5px 10px; right:0; bottom:0; text-align:right;}
			#focus .btn span {display:inline-block; _display:inline; _zoom:1; width:25px; height:10px; _font-size:0; margin-left:5px; cursor:pointer; background:#fe0000;}
			#focus .btn span.on {background:#fff;}
			#focus .preNext {width:45px; height:100px; position:absolute; top:90px; /*background:url(<?php echo $this->img('sprite.png');?>) no-repeat 0 0; */cursor:pointer;}
			#focus .pre {left:0;}
			#focus .next {right:0; background-position:right top;}
			</style>
			
			<script type="text/javascript">
			$(function() {
				var sWidth = $("#focus").width(); //获取焦点图的宽度（显示面积）
				var len = $("#focus ul li").length; //获取焦点图个数
				var index = 0;
				var picTimer;
				
				//以下代码添加数字按钮和按钮后的半透明条，还有上一页、下一页两个按钮
				var btn = "<div class='btnBg'></div><div class='btn'>";
				for(var i=0; i < len; i++) {
					btn += "<span></span>";
				}
				btn += "</div><div class='preNext pre'></div><div class='preNext next'></div>";
				$("#focus").append(btn);
				//$("#focus .btnBg").css("opacity",0.5);
			
				//为小按钮添加鼠标滑入事件，以显示相应的内容
				$("#focus .btn span").css("opacity",0.4).mouseenter(function() {
					index = $("#focus .btn span").index(this);
					showPics(index);
				}).eq(0).trigger("mouseenter");
			
				//上一页、下一页按钮透明度处理
				$("#focus .preNext").css("opacity",0.2).hover(function() {
					$(this).stop(true,false).animate({"opacity":"0.5"},300);
				},function() {
					$(this).stop(true,false).animate({"opacity":"0.2"},300);
				});
			
				//上一页按钮
				$("#focus .pre").click(function() {
					index -= 1;
					if(index == -1) {index = len - 1;}
					showPics(index);
				});
			
				//下一页按钮
				$("#focus .next").click(function() {
					index += 1;
					if(index == len) {index = 0;}
					showPics(index);
				});
			
				//本例为左右滚动，即所有li元素都是在同一排向左浮动，所以这里需要计算出外围ul元素的宽度
				$("#focus ul").css("width",sWidth * (len));
				
				//鼠标滑上焦点图时停止自动播放，滑出时开始自动播放
				$("#focus").hover(function() {
					clearInterval(picTimer);
				},function() {
					picTimer = setInterval(function() {
						showPics(index);
						index++;
						if(index == len) {index = 0;}
					},4000); //此4000代表自动播放的间隔，单位：毫秒
				}).trigger("mouseleave");
				
				//显示图片函数，根据接收的index值显示相应的内容
				function showPics(index) { //普通切换
					var nowLeft = -index*sWidth; //根据index值计算ul元素的left值
					$("#focus ul").stop(true,false).animate({"left":nowLeft},300); //通过animate()调整ul元素滚动到计算出的position
					//$("#focus .btn span").removeClass("on").eq(index).addClass("on"); //为当前的按钮切换到选中的效果
					$("#focus .btn span").stop(true,false).animate({"opacity":"0.4"},300).eq(index).stop(true,false).animate({"opacity":"1"},300); //为当前的按钮切换到选中的效果
				}
			});
	
	</script>
	<?php $ad = $this->action('banner','banner','服装内衣顶部',6);?>
		<div id="focus">
			<ul>
			<?php if(!empty($ad))foreach($ad as $row){?>
				<li><a href="<?php echo $row['ad_url'];?>" target="_blank"><img src="<?php echo SITE_URL.$row['ad_img'];?>" alt="<?php echo $row['ad_name'];?>" /></a></li>
			<?php } ?>
			</ul>
		</div>
		<!--banner-->
	</div>

	<div class="mzbanner">
		<div class="cate">
			<p class="title"></p>
			<ul>
			<?php if(!empty($rt['menu']))foreach($rt['menu'] as $nav){?>
			<li>
			<a href="<?php echo SITE_URL.$rt['cateinfo']['cat_url'].'.php?cid='.$nav['id'];?>"><?php echo $nav['name'];?></a>
				<?php if(!empty($nav['cat_id'])){ ?>
				<div class="subcatel">
					<dl>
					<dt>商品分类</dt>
					<?php foreach($nav['cat_id'] as $row){?>
					<dd><a href="<?php echo SITE_URL.$rt['cateinfo']['cat_url'].'.php?cid='.$row['id'];?>"><?php echo $row['name'];?></a></dd>
					<?php } ?>
					<div class="clear"></div>
					<dt>价格分类</dt>
					<dd><a href="<?php echo SITE_URL.$rt['cateinfo']['cat_url'].'.php?price=0-100';?>">100元以下</a></dd>
					<dd><a href="<?php echo SITE_URL.$rt['cateinfo']['cat_url'].'.php?price=100-200';?>">100-200元</a></dd>
					<dd><a href="<?php echo SITE_URL.$rt['cateinfo']['cat_url'].'.php?price=200-300';?>">200-300元</a></dd>
					<dd><a href="<?php echo SITE_URL.$rt['cateinfo']['cat_url'].'.php?price=300-400';?>">300-400元</a></dd>
					<dd><a href="<?php echo SITE_URL.$rt['cateinfo']['cat_url'].'.php?price=400-500';?>">400-500元</a></dd>
					<dd><a href="<?php echo SITE_URL.$rt['cateinfo']['cat_url'].'.php?price=500-';?>">500元以上</a></dd>
					<div class="clear"></div>
					</dl>
					
					<div class="subcater">
					<p>热门品牌</p>
					</div>
					<div class="clear"></div>
				</div>
				<?php } ?>
			</li>
			<?php } ?>
			</ul>
		</div>
		
		<div class="mzbannerR">
			<?php $this->element("jiajugundonggoods",array('gungoods'=>$rt['gungoods'])); ?>
			<?php $ad = $this->action('banner','banner','家具电器分类右边',1);?>
			<div class="shads">
			<p><a href="<?php echo $ad['ad_url'];?>" target="_blank"><img src="<?php echo !empty($ad['ad_img']) ? SITE_URL.$ad['ad_img'] : $this->img('sff.png');?>" alt="<?php echo $ad['ad_name'];?>" width="800" /></a></p>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="hotgoods">
			<ul>
			<?php foreach($rt['hotgoods'] as $rows){?>
			<?php
			$name = !empty($rows['gname']) ? $rows['gname'] : $rows['goods_name'];
			$url = !empty($rows['url']) ? $rows['url'] : SITE_URL.'product.php?id='.$rows['goods_id'];
			$img = !empty($rows['img']) ? SITE_URL.$rows['img'] : $rows['goods_thumb'];
			?>
			<li>
			<div class="imgbox">
			<a href="<?php echo $url;?>"><img src="<?php echo $img;?>" alt="<?php echo $name;?>" width="235" onload="loadimg(this,235,235)" title="<?php echo $name;?>" /></a>
			</div>
			<p class="fname"><a href="<?php echo $url;?>"><?php echo $name;?></a></p>
			<p class="price"><b>￥<?php echo $rows['pifa_price'];?></b><del>￥<?php echo $rows['shop_price'];?></del></p>
			</li>
			<?php } ?>
			<div class="clear"></div>
			</ul>
	</div>
	<?php if(!empty($rt['cats']))foreach($rt['cats'] as $cat){?>
	<div class="jjitem">
		<div class="title">
			<div style="width:700px; height:40px; line-height:40px; border-bottom:1px solid #ccc; margin:0px auto; text-align:center"><span><?php echo $cat['cat_name'];?></span></div>
		</div>
			<ul>
			<?php foreach($rt['cated'][$cat['tcid']] as $rows){?>
			<?php
			$name = !empty($rows['gname']) ? $rows['gname'] : $rows['goods_name'];
			$url = !empty($rows['url']) ? $rows['url'] : SITE_URL.'product.php?id='.$rows['goods_id'];
			$img = !empty($rows['img']) ? SITE_URL.$rows['img'] : SITE_URL.$rows['goods_img'];
			?>
			<li>
			<div class="imgbox">
			<a href="<?php echo $url;?>"><img src="<?php echo $img;?>" alt="<?php echo $name;?>" width="320" title="<?php echo $name;?>" /></a>
			</div>
			</li>
			<?php } ?>
			<div class="clear"></div>
			</ul>
	</div>
	<?php } ?>
	</div>
</div>
