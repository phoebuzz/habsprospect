<?php do_action('themeboy_before_searchform'); ?>
<form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
	<div class="row collapse">
		<?php do_action('themeboy_searchform_top'); ?>
		<div class="small-8 columns">
			<input type="text" value="" name="s" id="s" placeholder="<?php esc_attr_e('Search', 'themeboy'); ?>">
		</div>
		<?php do_action('themeboy_searchform_before_search_button'); ?>
		<div class="small-4 columns">
			<input type="submit" value="<?php esc_attr_e('Search', 'themeboy'); ?>" class="prefix button">
		</div>
		<?php do_action('themeboy_searchform_after_search_button'); ?>
	</div>
</form>
<?php do_action('themeboy_after_searchform'); ?>