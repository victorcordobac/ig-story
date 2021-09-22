<!DOCTYPE html>
<html>
	<head>
		<title>
			Instgram Graph API | IG User | Stories
		</title>
	</head>
	<body>
		<h1>
			Instgram Graph API | IG User | Stories
		</h1>
		<h2>
			<!-- display syntax for reference -->
			<?php echo $endpointSyntax; ?>
		</h2>
		<h3>
			User Stories Response
		</h3>
		<div>
			<!-- dump out the entire response -->
			<pre><?php print_r( $stories ); ?></pre>
		</div>
		<hr />
		<?php foreach ( $stories as $story ) : // loop over each story element ?>
			<?php if ( 'VIDEO' == $story['media_info']['media_type'] ) : // story media is a video ?>
				<div>
					<video controls poster="<?php echo $story['media_info']['thumbnail_url']; ?>" style="max-width:300px">
						<source src="<?php echo $story['media_info']['media_url']; ?>" />
					</video>
				</div>
			<?php elseif ( 'IMAGE' == $story['media_info']['media_type'] ) : // story media is an image ?>
				<div>
					<img src="<?php echo $story['media_info']['media_url']; ?>" style="max-width:300px" />
				</div>
			<?php endif; ?>
			<div>
				<b>
					<?php echo $story['media_info']['username']; ?>
				</b>
			</div>
			<a href="<?php echo $story['media_info']['permalink']; ?>" target="_blank">
				View on Instagram
			</a>
		<?php endforeach; ?>
	</body>
</html>