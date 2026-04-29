<?php
/**
 * Astra functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra
 * @since 1.0.0
 */

add_action( 'wp_enqueue_scripts', 'astra_child_enqueue_parent_theme_style' );
function astra_child_enqueue_parent_theme_style() {
	$parent_style = 'parent-style';
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), wp_get_theme()->get('Version') );
}


/**
 * 웹사이트
 * 폰트 스타일
 */
add_action('wp_enqueue_scripts', 'noto_font_enqueue_styles', '1');
function noto_font_enqueue_styles() {
	wp_enqueue_style( 'font_noto', get_stylesheet_directory_uri().'/css/fonts.css');
}

/**
 * 웹사이트
 * 스타일 파일
 */
add_action('wp_enqueue_scripts', 'project_enqueue_styles', '10');
function project_enqueue_styles() {
    wp_enqueue_style( 'project-basic-style', get_stylesheet_directory_uri().'/css/basic.css');
    wp_enqueue_style( 'project-style', get_stylesheet_directory_uri().'/css/ht_main.css');
}

/**
 * 관리자 화면
 * 수정 스타일시트
 */
add_action('admin_print_styles', 'ht_admin_css');
function ht_admin_css() {
    wp_enqueue_style( 'ht_admin_css', get_stylesheet_directory_uri() . '/css/ht_admin.css' );
    wp_enqueue_style( 'font_noto', get_stylesheet_directory_uri().'/css/fonts.css');
}

/**
 * 우커머스
 * 더보기/장바구니 버튼 제거
 */
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');


/**
 * 우커머스
 * 원화표시
 */
add_filter('woocommerce_currencies', 'my_woocommerce_currencies');
function my_woocommerce_currencies($currencies){
    $currencies['KRW'] = '대한민국';
    return $currencies;
}

add_filter('woocommerce_currency_symbol', 'my_woocommerce_currency_symbol', 10, 2);
function my_woocommerce_currency_symbol($currency_symbol, $currency){
    switch($currency){
        case 'KRW': $currency_symbol = '원'; break;
    }
    return $currency_symbol;
}

// username shortcode
function show_loggedin_function( $atts ) {
	global $current_user, $user_login;
    get_currentuserinfo();
	add_filter('widget_text', 'do_shortcode');
	if ($user_login)
		return $current_user->display_name;
}
add_shortcode( 'show_loggedin_as', 'show_loggedin_function' );

// [logout_button redirect="/" label="로그아웃"]
add_shortcode('logout_button', function( $atts ) {
  $atts = shortcode_atts([
    'redirect' => home_url('/'),
    'label'    => '로그아웃',
    'class'    => 'btn btn-primary btn-logout',
    'message'  => '로그아웃 하시겠습니까?'
  ], $atts, 'logout_button');

  if ( ! is_user_logged_in() ) return '';

  $url = wp_logout_url( esc_url( $atts['redirect'] ) );

  return '<a class="'. esc_attr($atts['class']) .'"
              href="'. esc_url($url) .'"
              onclick="return confirm(\''. esc_js($atts['message']) .'\')"><svg id="fi_18273095" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-name="Layer 1"  width="20" height="20"><g><path d="m12 19.5h-6c-.83 0-1.5-.67-1.5-1.5v-12c0-.83.67-1.5 1.5-1.5h6c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5h-6c-2.48 0-4.5 2.02-4.5 4.5v12c0 2.48 2.02 4.5 4.5 4.5h6c.83 0 1.5-.67 1.5-1.5s-.67-1.5-1.5-1.5z"></path><path d="m22.06 10.94-3-3c-.58-.58-1.54-.58-2.12 0-.28.28-.44.66-.44 1.06s.16.78.44 1.06l.44.44h-8.38c-.83 0-1.5.67-1.5 1.5s.67 1.5 1.5 1.5h8.38l-.44.44c-.28.28-.44.66-.44 1.06s.16.78.44 1.06.68.44 1.06.44.77-.15 1.06-.44l3-3c.58-.58.58-1.54 0-2.12z"></path></g></svg></a>';
});

// [login_button redirect="/dashboard" label="로그인" class="btn btn-login"]
add_shortcode('login_button', function( $atts ) {
  $atts = shortcode_atts([
    'redirect' => home_url('/'),
    'label'    => '로그인',
    'class'    => 'btn btn-primary btn-login'
  ], $atts, 'login_button');

  if ( is_user_logged_in() ) return '';

  $url = wp_login_url( esc_url( $atts['redirect'] ) );
  return '<a class="'. esc_attr($atts['class']) .'" href="'. esc_url($url) .'" title="'. esc_html($atts['label']) .'"><svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" id="fi_17187658" width="20" height="20"><g id="Layer_20" data-name="Layer 20"><path d="m52.62 14.37a4.59 4.59 0 0 0 -3.51-1.47 4.67 4.67 0 0 0 -3.47 1.69 4.65 4.65 0 0 0 .19 6.07 18.78 18.78 0 0 1 -15.49 31.46 18.77 18.77 0 0 1 -12.13-31.44 4.65 4.65 0 0 0 -3.31-7.78 4.56 4.56 0 0 0 -3.53 1.48 28 28 0 0 0 -7.16 23 28.3 28.3 0 0 0 26.73 24h1.07a28.07 28.07 0 0 0 20.61-47.01z"></path><path d="m32 34.92a4.65 4.65 0 0 0 4.65-4.65v-23.12a4.65 4.65 0 0 0 -9.3 0v23.12a4.65 4.65 0 0 0 4.65 4.65z"></path></g></svg></a>';
});

add_filter('wp_nav_menu_objects', function($items) {
    foreach ($items as $item) {
        if ($item->title === '로그아웃') {
            $item->url = wp_logout_url(home_url('/'));
        }
    }
    return $items;
});

add_action('wp_footer', function() { ?>
<script>
window.addEventListener("load", function() {
    setTimeout(function() {
        var container = document.querySelector(".subscription-description.subscription-price");
        if (!container) return;

        if (window.location.href.indexOf("cosmosfarm_product_id=5448") !== -1) {
            container.style.setProperty("display", "none", "important");
            return;
        }

        var priceEl = container.querySelector(".subscription-price");
        var firstPriceEl = container.querySelector(".subscription-first-price");

        if (priceEl && firstPriceEl) {
            var origPrice = priceEl.textContent;
            var firstPrice = firstPriceEl.textContent.replace("첫 결제 가격 ", "");

            container.innerHTML =
                '<span style="margin-right:6px;">→ 첫 달 결제 가격</span>' +
                '<span style="text-decoration:line-through;color:#787c82;margin-right:6px;">' + origPrice + '</span>' +
                '<span style="font-weight:700;color:#b91c1c;">' + firstPrice + '</span>';
        }
    }, 500);
});
</script>
<?php });

add_action('wp_footer', function() {
    if (isset($_GET['cosmosfarm_product_id']) && $_GET['cosmosfarm_product_id'] == '5448') {
        echo '<style>.cosmosfarm-members-subscription > .subscription-description.subscription-price { display: none !important; }</style>';
    }
}, 99);

add_action('wp_footer', function() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('tbody td.kboard-list-user').forEach(function (td) {
            var name = td.textContent.trim();
            if (name.length > 1) {
                td.textContent = name.charAt(0) + '*'.repeat(name.length - 1);
            }
        });

        document.querySelectorAll('.detail-attr.detail-writer .detail-value').forEach(function (el) {
            var name = el.textContent.trim();
            if (name.length > 1) {
                el.textContent = name.charAt(0) + '*'.repeat(name.length - 1);
            }
        });
    });
    </script>
    <?php
});


// AJAX 핸들러
add_action('wp_ajax_load_class_products', 'load_class_products_ajax');
add_action('wp_ajax_nopriv_load_class_products', 'load_class_products_ajax');

function load_class_products_ajax() {
    $paged    = isset($_POST['paged'])    ? intval($_POST['paged'])               : 1;
    $per_page = isset($_POST['per_page']) ? intval($_POST['per_page'])             : -1;
    $orderby  = isset($_POST['orderby'])  ? sanitize_text_field($_POST['orderby']) : 'menu_order';
    $order    = isset($_POST['order'])    ? sanitize_text_field($_POST['order'])   : 'ASC';
    $search   = isset($_POST['search'])   ? sanitize_text_field($_POST['search'])  : '';

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => $per_page,
        'paged'          => $paged,
        'orderby'        => $orderby,
        'order'          => $order,
        'post_status'    => 'publish',
        'tax_query'      => [[
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => ['jungchul-lecture'],
            'operator' => 'IN',
        ]],
    ];

    if ($search !== '') {
        $args['s'] = $search;
    }

    $loop = new WP_Query($args);
    ob_start();

    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

    if ($loop->have_posts()) {
        woocommerce_product_loop_start();
        while ($loop->have_posts()) {
            $loop->the_post();
            wc_get_template_part('content', 'product');
        }
        woocommerce_product_loop_end();
    } else {
        echo '<p style="padding:20px;">검색 결과가 없습니다.</p>';
    }

    wp_reset_postdata();

    wp_send_json_success([
        'html'      => ob_get_clean(),
        'max_pages' => $loop->max_num_pages,
    ]);
}

// 숏코드
add_shortcode('class_products', function($atts) {
    $atts = shortcode_atts([
        'per_page' => -1,
        'orderby'  => 'menu_order',
        'order'    => 'ASC',
    ], $atts);

    $per_page = intval($atts['per_page']);
    $orderby  = $atts['orderby'];
    $order    = $atts['order'];

    $args = [
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'paged'          => 1,
        'orderby'        => $orderby,
        'order'          => $order,
        'post_status'    => 'publish',
        'tax_query'      => [[
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => ['jungchul-lecture'],
            'operator' => 'IN',
        ]],
    ];

    $loop = new WP_Query($args);
    ob_start();

    echo '<div style="margin-bottom:16px;">
        <button id="goto-coming-soon" style="padding:10px 24px;background:#fff;color:#95292A;border:2px solid #95292A;border-radius:50px;font-size:15px;font-weight:700;cursor:pointer;">📅 공개 예정 강좌 보기</button>
    </div>
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:24px;">
        <form id="class-products-search-form" style="display:flex;gap:8px;">
            <input type="text" id="class-search-input" placeholder="강의 이름으로 검색..." style="flex:1;min-width:0;padding:10px 16px;border:2px solid #95292A;border-radius:8px;font-size:16px;outline:none;box-sizing:border-box;">
            <button type="submit" style="padding:10px 20px;background:#95292A;color:#fff;border:none;border-radius:8px;font-size:16px;font-weight:700;cursor:pointer;white-space:nowrap;">검색</button>
        </form>
    </div>';

    if ($loop->have_posts()) {
        echo '<div class="woocommerce">';
        echo '<div id="class-products-container">';
        woocommerce_product_loop_start();
        while ($loop->have_posts()) {
            $loop->the_post();
            wc_get_template_part('content', 'product');
        }
        woocommerce_product_loop_end();
        echo '</div>';
        echo '</div>';
    }

    wp_reset_postdata();

    $ajax_url = esc_url(admin_url('admin-ajax.php'));
    echo "<script>
    jQuery(function(\$) {

        function applyPost410Style(container) {
            var li = (container || document).querySelector('ul.products li.post-410');
            if (!li) return;
            li.style.setProperty('grid-column', '1 / -1', 'important');
            var wrap = li.querySelector('.astra-shop-thumbnail-wrap');
            if (wrap) {
                wrap.style.setProperty('width', '100%', 'important');
                wrap.style.setProperty('height', 'auto', 'important');
                wrap.style.setProperty('border-radius', '20px', 'important');
                wrap.style.setProperty('overflow', 'hidden', 'important');
                wrap.style.removeProperty('aspect-ratio');
            }
            var img = li.querySelector('img');
            if (img) {
                img.style.setProperty('width', '100%', 'important');
                img.style.setProperty('height', 'auto', 'important');
                img.style.setProperty('display', 'block', 'important');
                img.style.removeProperty('object-fit');
                img.style.removeProperty('position');
            }
        }

        function applyComingSoonLayout() {
            var \$list = \$('#class-products-container ul.products:not(.coming-soon-products)');
            if (!\$list.length) \$list = \$('ul.products:not(.coming-soon-products)');

            \$('.coming-soon-products li').appendTo(\$list);
            \$('.coming-soon-divider').remove();
            \$('.coming-soon-products').remove();

            var \$comingSoon = \$list.find('li.product_tag-coming-soon');
            if (\$comingSoon.length > 0) {
                var \$divider = \$('<div class=\"coming-soon-divider\">공개 예정 강의</div>');
                var \$newList = \$('<ul class=\"products columns-3 coming-soon-products\"></ul>');
                \$comingSoon.appendTo(\$newList);
                \$newList.insertAfter(\$list);
                \$divider.insertAfter(\$list);
            }
        }

        applyPost410Style(null);
        applyComingSoonLayout();

        \$(document).on('click', '#goto-coming-soon', function() {
            var target = document.querySelector('.coming-soon-divider');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });

        var ajaxUrl = '{$ajax_url}';

        function loadProducts(search) {
            \$.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    action:   'load_class_products',
                    paged:    1,
                    per_page: -1,
                    orderby:  'menu_order',
                    order:    'ASC',
                    search:   search
                },
                beforeSend: function() {
                    \$('#class-products-container').css('opacity', '0.5');
                },
                success: function(res) {
                    if (res.success) {
                        \$('#class-products-container').html(res.data.html).css('opacity', '1');
                        applyPost410Style(document.getElementById('class-products-container'));
                        applyComingSoonLayout();
                    }
                }
            });
        }

        \$('#class-products-search-form').on('submit', function(e) {
            e.preventDefault();
            var search = \$('#class-search-input').val().trim();
            loadProducts(search);
        });

    });
    </script>";

    return ob_get_clean();
});

add_action('woocommerce_product_query', function($q) {
    if (!is_admin() && is_shop()) {
        $q->set('tax_query', [[
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => ['jungchul-lecture'],
            'operator' => 'NOT IN',
        ]]);
    }
});
