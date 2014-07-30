<?php
/**
 * Override for the month view single day template.
 *
 * This file should live at [your-theme]/tribe-events/month/single-day.php - it is one part of a workaround to avoid
 * empty day views from being indexed by search engines (as those pages return a 404 status).
 */
 
if ( !defined('ABSPATH') ) { die('-1'); } ?>
 
<?php $day = tribe_events_get_current_month_day() ?>
 
<?php if ($day['date'] != 'previous' && $day['date'] != 'next') : ?>
 
        <?php $has_events = false ?>
        <?php ob_start() ?>
 
        <!-- Events List -->
        <?php while ($day['events']->have_posts()) : $day['events']->the_post() ?>
                <?php tribe_get_template_part('month/single', 'event') ?>
                <?php $has_events = true ?>
        <?php endwhile; ?>
 
        <!-- View More -->
        <?php if ($day['view_more']) : ?>
                <div class="tribe-events-viewmore">
                        <a href="<?php echo $day['view_more'] ?>">View All <?php echo $day['total_events'] ?> &raquo;</a>
                </div>
        <?php endif ?>
 
        <?php $day_items = ob_get_clean() ?>
 
        <!-- Day Header -->
        <div id="tribe-events-daynum-<?php echo $day['daynum'] ?>">
 
                <a href="<?php echo tribe_get_day_link($day['date']) ?>" <?php if (!$has_events) echo 'rel="nofollow"' ?>><?php echo $day['daynum'] ?></a>
 
        </div>
 
        <?php echo $day_items ?>
 
<?php endif; ?>