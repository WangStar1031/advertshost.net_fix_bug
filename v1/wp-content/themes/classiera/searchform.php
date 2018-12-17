<?php
/**
 * The template for displaying search form
 *
 * @package WordPress
 * @subpackage FoundationPress
 * @since FoundationPress 1.0
 */
?>
<!-- search -->	
<div class="widget-content">
	<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
		<div class="input-group custom-wp-search">
			<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e( 'Enter keyword', 'classiera' ); ?>">
			<span class="input-group-btn">
				<button class="btn btn-wp-search" type="submit">
					<i class="fa fa-search"></i>
				</button>
			</span>
		</div>

	</form>
</div>

