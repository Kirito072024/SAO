<?php
/**
 * Головна сторінка (Налаштування → Читання → «Статична сторінка»).
 *
 * Секції:
 * hero → вітання + цифри → Айнкрад → механіка → історія (текст самої сторінки з редактора)
 * → персонажі (CPT) → гільдії (CPT) → останні новини (записи) → заклик написати → цікавий факт
 *
 * @package SAO_Aincrad
 */

get_header();

$characters_url = get_post_type_archive_link( 'sao_character' );
$guilds_url     = get_post_type_archive_link( 'sao_guild' );
$news_url       = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
$contacts_page  = get_pages(
	array(
		'meta_key'   => '_wp_page_template', // phpcs:ignore WordPress.DB.SlowDBQuery
		'meta_value' => 'page-contacts.php', // phpcs:ignore WordPress.DB.SlowDBQuery
		'number'     => 1,
	)
);
$contacts_url   = $contacts_page ? get_permalink( $contacts_page[0] ) : '';
?>

<!-- ============ HERO ============ -->
<section class="hero">
	<?php sao_sky(); ?>
	<div class="hero__inner container">
		<p class="kicker kicker--glow"><?php echo esc_html( sao_opt( 'sao_hero_kicker' ) ); ?></p>
		<h1 class="hero__title"><?php echo esc_html( sao_opt( 'sao_hero_title' ) ); ?></h1>
		<p class="hero__subtitle"><?php echo esc_html( sao_opt( 'sao_hero_subtitle' ) ); ?></p>
		<div class="hero__actions">
			<a class="btn btn--primary" href="#aincrad"><?php esc_html_e( 'Увійти в Айнкрад', 'sao-aincrad' ); ?> <?php echo sao_icon( 'arrow' ); // phpcs:ignore ?></a>
			<?php if ( sao_opt( 'sao_watch_url' ) ) : ?>
				<a class="btn btn--ghost" href="<?php echo esc_url( sao_opt( 'sao_watch_url' ) ); ?>" target="_blank" rel="noopener noreferrer"><?php echo sao_icon( 'play' ); // phpcs:ignore ?> <?php esc_html_e( 'Дивитися 1 сезон', 'sao-aincrad' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
	<a class="hero__scroll" href="#welcome" aria-label="<?php esc_attr_e( 'Прокрутити вниз', 'sao-aincrad' ); ?>"><span></span></a>
</section>

<!-- ============ ВІТАННЯ + ЦИФРИ ============ -->
<section class="section" id="welcome">
	<div class="container">
		<div class="panel welcome" data-reveal>
			<h2 class="section-title"><?php esc_html_e( 'Ласкаво просимо', 'sao-aincrad' ); ?></h2>
			<p class="lead"><?php echo esc_html( sao_opt( 'sao_intro' ) ); ?></p>
		</div>

		<ul class="stats" data-reveal>
			<li class="stat"><span class="stat__num" data-count="100">100</span><span class="stat__label"><?php esc_html_e( 'поверхів замку', 'sao-aincrad' ); ?></span></li>
			<li class="stat"><span class="stat__num" data-count="10000">10 000</span><span class="stat__label"><?php esc_html_e( 'гравців у пастці', 'sao-aincrad' ); ?></span></li>
			<li class="stat"><span class="stat__num" data-count="2">2</span><span class="stat__label"><?php esc_html_e( 'роки в грі', 'sao-aincrad' ); ?></span></li>
			<li class="stat"><span class="stat__num" data-count="6147">6 147</span><span class="stat__label"><?php esc_html_e( 'повернулися додому', 'sao-aincrad' ); ?></span></li>
		</ul>
	</div>
</section>

<!-- ============ АЙНКРАД ============ -->
<section class="section" id="aincrad">
	<div class="container">
		<div class="panel split" data-reveal>
			<figure class="split__media">
				<img class="float-img" src="<?php echo esc_url( SAO_URI . '/assets/images/aincrad-960.webp' ); ?>"
					srcset="<?php echo esc_url( SAO_URI . '/assets/images/aincrad-480.webp' ); ?> 480w, <?php echo esc_url( SAO_URI . '/assets/images/aincrad-960.webp' ); ?> 960w"
					sizes="(min-width: 860px) 480px, 100vw" width="960" height="540"
					alt="<?php esc_attr_e( 'Айнкрад — летючий залізний замок у небі', 'sao-aincrad' ); ?>" loading="lazy" decoding="async">
			</figure>
			<div class="split__text">
				<h2 class="section-title"><?php esc_html_e( 'Айнкрад', 'sao-aincrad' ); ?></h2>
				<p><?php esc_html_e( 'Айнкрад — величезний залізний замок, що висить у небі. Він складається зі 100 поверхів. На кожному є місто, лабіринт і бос, якого потрібно перемогти, щоб відкрити шлях вище.', 'sao-aincrad' ); ?></p>
				<ul class="floors">
					<li><b>1</b> <?php esc_html_e( 'Місто Початку — тут почалася «смертельна гра»', 'sao-aincrad' ); ?></li>
					<li><b>22</b> <?php esc_html_e( 'Тихий лісовий поверх, будиночок Кіріто й Асуни', 'sao-aincrad' ); ?></li>
					<li><b>74</b> <?php esc_html_e( 'Бос «Блискучі очі» і подвійні мечі', 'sao-aincrad' ); ?></li>
					<li><b>75</b> <?php esc_html_e( 'Колінія і фінальна дуель із Хізкліфом', 'sao-aincrad' ); ?></li>
				</ul>
			</div>
		</div>
	</div>
</section>

<!-- ============ МЕХАНІКА ============ -->
<section class="section" id="mechanics">
	<div class="container">
		<h2 class="section-title" data-reveal><?php esc_html_e( 'Механіка гри', 'sao-aincrad' ); ?></h2>
		<ul class="tiles">
			<?php
			$tiles = array(
				array( 'helmet', 'NerveGear', 'Шолом повністю занурює гравця у віртуальний світ — усі п\'ять відчуттів.' ),
				array( 'sword', 'Sword Skills', 'Магії немає: бої ведуться мечами та навичками меча. Унікальна навичка Кіріто — Dual Blades.' ),
				array( 'shield', 'Рівні та гільдії', 'Є рівні, смужка HP, інвентар, крафт і гільдії. Сильніше разом.' ),
				array( 'heart', 'Безпечні зони', 'У містах гравцям не можна завдати шкоди — тут відпочивають перед лабіринтом.' ),
				array( 'shield', 'Колір курсора', 'Зелений — звичайний гравець, жовтогарячий — злочинець, червоний — убивця.' ),
				array( 'skull', 'Головне правило', 'Смерть у грі означає смерть у реальності. Другого життя немає.' ),
			);
			foreach ( $tiles as $i => $tile ) :
				?>
				<li class="tile<?php echo 'skull' === $tile[0] ? ' tile--danger' : ''; ?>" data-reveal style="--delay: <?php echo (int) $i * 60; ?>ms">
					<span class="tile__icon"><?php echo sao_icon( $tile[0] ); // phpcs:ignore ?></span>
					<h3 class="tile__title"><?php echo esc_html( $tile[1] ); ?></h3>
					<p><?php echo esc_html( $tile[2] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>

<!-- ============ ІСТОРІЯ (текст сторінки «Головна» з редактора) ============ -->
<?php while ( have_posts() ) : the_post(); ?>
	<?php if ( get_the_content() ) : ?>
		<section class="section" id="story">
			<div class="container">
				<article class="panel story" data-reveal>
					<h2 class="section-title"><?php esc_html_e( 'Чому гра стала смертельною', 'sao-aincrad' ); ?></h2>
					<div class="entry-content"><?php the_content(); ?></div>
				</article>
			</div>
		</section>
	<?php endif; ?>
<?php endwhile; ?>

<!-- ============ ПЕРСОНАЖІ ============ -->
<?php
$characters = new WP_Query(
	array(
		'post_type'      => 'sao_character',
		'posts_per_page' => 4,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	)
);
if ( $characters->have_posts() ) :
	?>
	<section class="section" id="characters">
		<div class="container">
			<div class="section-head" data-reveal>
				<h2 class="section-title"><?php esc_html_e( 'Персонажі', 'sao-aincrad' ); ?></h2>
				<a class="link-more" href="<?php echo esc_url( $characters_url ); ?>"><?php esc_html_e( 'Усі персонажі', 'sao-aincrad' ); ?> <?php echo sao_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<div class="grid grid--4">
				<?php
				while ( $characters->have_posts() ) :
					$characters->the_post();
					get_template_part( 'template-parts/card', 'character' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- ============ ГІЛЬДІЇ ============ -->
<?php
$guilds = new WP_Query(
	array(
		'post_type'      => 'sao_guild',
		'posts_per_page' => 4,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	)
);
if ( $guilds->have_posts() ) :
	?>
	<section class="section" id="clans">
		<div class="container">
			<div class="section-head" data-reveal>
				<h2 class="section-title"><?php esc_html_e( 'Клани та гільдії', 'sao-aincrad' ); ?></h2>
				<a class="link-more" href="<?php echo esc_url( $guilds_url ); ?>"><?php esc_html_e( 'Усі гільдії', 'sao-aincrad' ); ?> <?php echo sao_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<div class="grid grid--2">
				<?php
				while ( $guilds->have_posts() ) :
					$guilds->the_post();
					get_template_part( 'template-parts/card', 'guild' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- ============ НОВИНИ ============ -->
<?php
$latest = new WP_Query(
	array(
		'post_type'           => 'post',
		'posts_per_page'      => 3,
		'ignore_sticky_posts' => true,
	)
);
if ( $latest->have_posts() ) :
	?>
	<section class="section" id="news">
		<div class="container">
			<div class="section-head" data-reveal>
				<h2 class="section-title"><?php esc_html_e( 'Новини Айнкраду', 'sao-aincrad' ); ?></h2>
				<a class="link-more" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( 'Уся хроніка', 'sao-aincrad' ); ?> <?php echo sao_icon( 'arrow' ); // phpcs:ignore ?></a>
			</div>
			<div class="timeline">
				<?php
				while ( $latest->have_posts() ) :
					$latest->the_post();
					get_template_part( 'template-parts/news', 'item' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- ============ ЗАКЛИК + ФАКТ ============ -->
<section class="section">
	<div class="container">
		<div class="cta" data-reveal>
			<div>
				<h2 class="cta__title"><?php esc_html_e( 'Є питання або ідея?', 'sao-aincrad' ); ?></h2>
				<p><?php esc_html_e( 'Напиши нам — заявка потрапить прямо в адмінку сайту.', 'sao-aincrad' ); ?></p>
			</div>
			<?php if ( $contacts_url ) : ?>
				<a class="btn btn--primary" href="<?php echo esc_url( $contacts_url ); ?>"><?php esc_html_e( 'Написати', 'sao-aincrad' ); ?> <?php echo sao_icon( 'arrow' ); // phpcs:ignore ?></a>
			<?php endif; ?>
		</div>

		<?php if ( sao_opt( 'sao_fact' ) ) : ?>
			<aside class="fact" data-reveal>
				<p class="fact__label"><?php esc_html_e( 'Цікавий факт', 'sao-aincrad' ); ?></p>
				<p><?php echo esc_html( sao_opt( 'sao_fact' ) ); ?></p>
			</aside>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
