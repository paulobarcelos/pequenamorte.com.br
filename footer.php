			</div><?php #end .inner ?>
			
			<?php
				wp_nav_menu( array(
					'menu' => 'main',
					'container' => 'nav'
				));
			?>

			<div class="logo">

			</div>

		</div><?php #end .outer ?>
			

		<footer class="footer">
			<div class="outer">
				<?php
					wp_nav_menu( array(
						'menu' => 'social',
						'container' => 'nav'
					));
				?>
				<?php
					wp_nav_menu( array(
						'items_wrap' => '<ul id="%1$s" class="%2$s">'.'<li class="title">'.__('Próximos Shows:').'</li>'.'%3$s</ul>',
						'menu' => 'footer',
						'container' => 'nav'
					));
				?>
			</div>
		</footer>

	</article>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.9.0.min.js"><\/script>')</script>
	<script src="<?php echo get_template_directory_uri();?>/js/script.js"></script>

	<?php wp_footer(); ?>
</body>
</html>