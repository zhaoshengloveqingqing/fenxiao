<?php if(!empty($rt['commentlist'])){?>
<div class="clear"></div>
<table width="100%" cellpadding="3" cellspacing="5" border="0">
<?php foreach($rt['commentlist'] as $row){?>
	<tr>
		<td align="left">
		<div style="border-bottom:1px solid #ededed; padding-bottom:3px; line-height:22px; margin-bottom:5px;">
			<div style="width:100%; ">
                <span style='font-size:15px;font-weight: 700;'><?php echo $row['nickname'];?></span>
            <div style='float:right;border: 1px solid #ededed ;padding: 2px 4px;'>
                <i style='' class="icon icon-rank icon-normal"></i>
                中评
            </div>
            <span style='color:#B3B3B3;margin-left: 5px;'><?php echo date('Y-m-d',$row['add_time']);?></span>
        </div>
            <div style="width:100%; color:#999999; margin: 5px auto;">
                <?php echo $row['content'];?>
                </div>
                <div class="clear"></div>
                <?php if(!empty($row['pics'])){
                $pics = explode('|',$row['pics']);
                foreach($pics as $imgs){
                    ?>
                    <a href="<?php echo SITE_URL.$imgs;?>"><img src=" <?php echo ADMIN_URL;?>tpl/10/images/product.png" height="40" style=" padding:1px; border:1px solid #ededed; cursor:pointer; float:left" /></a>
                    <a href="<?php echo SITE_URL.$imgs;?>"><img src=" <?php echo ADMIN_URL;?>tpl/10/images/product.png" height="40" style=" padding:1px; border:1px solid #ededed; cursor:pointer; float:left" /></a>
                    <a href="<?php echo SITE_URL.$imgs;?>"><img src=" <?php echo ADMIN_URL;?>tpl/10/images/product.png" height="40" style=" padding:1px; border:1px solid #ededed; cursor:pointer; float:left" /></a>
                    <a href="<?php echo SITE_URL.$imgs;?>"><img src=" <?php echo ADMIN_URL;?>tpl/10/images/product.png" height="40" style=" padding:1px; border:1px solid #ededed; cursor:pointer; float:left" /></a>
                    <a href="<?php echo SITE_URL.$imgs;?>"><img src=" <?php echo ADMIN_URL;?>tpl/10/images/product.png" height="40" style=" padding:1px; border:1px solid #ededed; cursor:pointer; float:left" /></a>
                    <?php
                }
                }
                ?>
                <div class="clear"></div>
        </div>
    </td>
</tr>
<?php } ?>
</table>
<?php if(!empty($rt['commentpage'])){?>
<div  class="pages">
<?php echo $rt['commentpage']['first'].'&nbsp;'.$rt['commentpage']['prev'].'&nbsp;'.(!empty($rt['commentpage1']['list'])?implode('&nbsp;',$rt['commentpage']['list']).'&nbsp;':"").$rt['commentpage']['next'].'&nbsp;'.$rt['commentpage']['last'];?>
</div>
<?php }}else{ ?>
暂无评论
<?php } ?>
