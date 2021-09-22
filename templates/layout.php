<?php foreach ($stories as $story) : // loop over each story element 
?>
<?php if ('VIDEO' == $story['media_info']['media_type']) : // story media is a video 
	?>
<div style="text-align:center">
    <div>
        <video controls poster="<?php echo $story['media_info']['thumbnail_url']; ?>" style="max-width:300px">
            <source src="<?php echo $story['media_info']['media_url']; ?>" />
        </video>
    </div>
    <?php elseif ('IMAGE' == $story['media_info']['media_type']) : // story media is an image 
		?>
    <div>
        <img src="<?php echo $story['media_info']['media_url']; ?>" style="max-width:300px" />
    </div>
    <?php endif; ?>
    <div>
        <b>
            <?php echo $story['media_info']['username']; ?>
        </b>
    </div>
    <button href="<?php echo $story['media_info']['permalink']; ?>" target="_blank" style="color: black;">
        Ver en instagram
        <i class="fa fa-instagram">
        </i>
    </button>
</div>
<?php endforeach; ?>