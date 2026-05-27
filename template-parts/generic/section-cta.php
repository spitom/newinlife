<?php
defined('ABSPATH') || exit;

$container = inlife_container_class();

$kicker = get_sub_field('cta_kicker');
$title  = get_sub_field('cta_title');
$text   = get_sub_field('cta_text');

$button  = get_sub_field('cta_button');

$variant = get_sub_field('cta_variant') ?: 'default';
$width   = get_sub_field('cta_width') ?: 'normal';

$classes = [
	'generic-cta',
	'generic-cta--' . $variant,
	'generic-cta--' . $width,
];
?>

<section class="page-section generic-section">

	<div class="<?php echo esc_attr($container); ?>">

		<div class="<?php echo esc_attr(implode(' ', $classes)); ?> c-surface">

			<?php if ($kicker || $title) : ?>

				<header class="generic-cta__header section-heading">

					<?php if ($kicker) : ?>
						<p class="section-kicker">
							<?php echo esc_html($kicker); ?>
						</p>
					<?php endif; ?>

					<?php if ($title) : ?>
						<h2 class="section-title">
							<?php echo esc_html($title); ?>
						</h2>
					<?php endif; ?>

				</header>

			<?php endif; ?>

			<?php if ($text) : ?>

				<div class="generic-cta__content c-editorial-content">
					<?php echo wp_kses_post($text); ?>
				</div>

			<?php endif; ?>

			<?php if (is_array($button) && !empty($button['link']) && is_array($button['link'])) : ?>

                <?php
                $link = $button['link'];

                $button_class = 'btn btn-primary';

                if (!empty($button['style'])) {
                    if ('secondary' === $button['style']) {
                        $button_class = 'btn btn-outline-primary';
                    } elseif ('link' === $button['style']) {
                        $button_class = 'c-readmore';
                    }
                }
                ?>

                <div class="generic-cta__actions">

                    <a
                        class="<?php echo esc_attr($button_class); ?>"
                        href="<?php echo esc_url($link['url']); ?>"
                        <?php if (!empty($link['target'])) : ?>
                            target="<?php echo esc_attr($link['target']); ?>"
                        <?php endif; ?>
                    >
                        <?php echo esc_html($link['title'] ?: __('Zobacz więcej', 'understrap-child')); ?>
                    </a>

                </div>

            <?php endif; ?>

		</div>

	</div>

</section>