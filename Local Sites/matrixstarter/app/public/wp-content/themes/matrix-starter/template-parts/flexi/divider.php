<?php
// Get padding values for all breakpoints or set default values
$padding_top_xxs = get_sub_field('padding_top_xxs') ?: 'pt-8';
$padding_bottom_xxs = get_sub_field('padding_bottom_xxs') ?: 'pb-8';
$padding_top_xs = get_sub_field('padding_top_xs') ?: 'xs:pt-8';
$padding_bottom_xs = get_sub_field('padding_bottom_xs') ?: 'xs:pb-8';
$padding_top_mob = get_sub_field('padding_top_mob') ?: 'mob:pt-8';
$padding_bottom_mob = get_sub_field('padding_bottom_mob') ?: 'mob:pb-8';
$padding_top_sm = get_sub_field('padding_top_sm') ?: 'sm:pt-8';
$padding_bottom_sm = get_sub_field('padding_bottom_sm') ?: 'sm:pb-8';
$padding_top_md = get_sub_field('padding_top_md') ?: 'md:pt-8';
$padding_bottom_md = get_sub_field('padding_bottom_md') ?: 'md:pb-8';
$padding_top_lg = get_sub_field('padding_top_lg') ?: 'lg:pt-8';
$padding_bottom_lg = get_sub_field('padding_bottom_lg') ?: 'lg:pb-8';
$padding_top_xl = get_sub_field('padding_top_xl') ?: 'xl:pt-8';
$padding_bottom_xl = get_sub_field('padding_bottom_xl') ?: 'xl:pb-8';
$padding_top_xxl = get_sub_field('padding_top_xxl') ?: 'xxl:pt-8';
$padding_bottom_xxl = get_sub_field('padding_bottom_xxl') ?: 'xxl:pb-8';
$padding_top_ultrawide = get_sub_field('padding_top_ultrawide') ?: 'ultrawide:pt-8';
$padding_bottom_ultrawide = get_sub_field('padding_bottom_ultrawide') ?: 'ultrawide:pb-8';

// Get background color or set default value
$background_color = get_sub_field('background_color') ?: '#FFFFFF';
?>
<div class="<?php echo esc_attr(
    $padding_top_xxs . ' ' .
    $padding_bottom_xxs . ' ' .
    $padding_top_xs . ' ' .
    $padding_bottom_xs . ' ' .
    $padding_top_mob . ' ' .
    $padding_bottom_mob . ' ' .
    $padding_top_sm . ' ' .
    $padding_bottom_sm . ' ' .
    $padding_top_md . ' ' .
    $padding_bottom_md . ' ' .
    $padding_top_lg . ' ' .
    $padding_bottom_lg . ' ' .
    $padding_top_xl . ' ' .
    $padding_bottom_xl . ' ' .
    $padding_top_xxl . ' ' .
    $padding_bottom_xxl . ' ' .
    $padding_top_ultrawide . ' ' .
    $padding_bottom_ultrawide
); ?>" style="background-color: <?php echo esc_attr($background_color); ?>;"></div>
