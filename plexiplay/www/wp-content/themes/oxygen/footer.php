
	
	<?php if( ! defined("NO_FOOTER_MENU")): ?>
	
			<?php get_template_part('tpls/footer-main'); ?>
			
		</div>
		
	</div>
	
	<?php endif; ?>
	
	
	<?php if(isset($post) && in_array($post->page_template, array('contact.php')) && in_array(HEADER_TYPE, array(2,3,4))): ?>
	<div class="wrapper-contact">
		
		<?php define("SHOW_FOOTER", 1); ?>
		
		<div class="main">
			<?php get_template_part('tpls/footer-main'); ?>
		</div>
		
	</div>
	<?php endif; ?>
	
<?php wp_footer(); ?>
<script>
jQuery('#payment').remove();
</script>
</body>
</html>