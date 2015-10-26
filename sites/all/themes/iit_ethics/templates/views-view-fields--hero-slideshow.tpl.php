<?php
if ($fields['field_link_to']->content) {
?>

<?php 
	$linkTarget = ($fields['field_open_new_window']->content == 1) ? ' target="_blank" ' : ' ';
?>

<div class="slideshow-item">
	<a href="<?php print $fields['field_link_to']->content; ?>"<?php print $linkTarget ?>style="color: <?php print $fields['field_slide_text_color']->content; ?>;">
		<div class="slide-caption" style="background-color:<?php print $fields['field_slide_color']->content; ?>;">
			<h2 class="slide-title" style="color: <?php print $fields['field_slide_text_color']->content; ?>;"><?php print $fields['field_slide_text_title']->content; ?></h2>
			<div class="slide-body" style="color: <?php print $fields['field_slide_text_color']->content; ?>;"><?php print $fields['body']->content; ?></div>
		</div>
	</a>
	<div class="slide-image">
		<a href="<?php print $fields['field_link_to']->content; ?>"<?php print $linkTarget ?>><?php print $fields['field_hero_image']->content; ?></a>
		<a href="<?php print $fields['field_link_to']->content; ?>"<?php print $linkTarget ?>class="slide-show-more" style="background-color:<?php print $fields['field_slide_color']->content; ?>; color: <?php print $fields['field_slide_text_color']->content; ?>;">Show Me More &raquo;</a>
	</div>
</div>

<?php
} else {
?>

<div class="slideshow-item">
		<div class="slide-caption" style="background-color:<?php print $fields['field_slide_color']->content; ?>;">
			<h2 class="slide-title" style="color: <?php print $fields['field_slide_text_color']->content; ?>;"><?php print $fields['field_slide_text_title']->content; ?></h2>
			<div class="slide-body" style="color: <?php print $fields['field_slide_text_color']->content; ?>;"><?php print $fields['body']->content; ?></div>
		</div>
	<div class="slide-image">
		<?php print $fields['field_hero_image']->content; ?>
	</div>
</div>

<?php
}
?>