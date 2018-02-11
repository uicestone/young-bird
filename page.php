<?php get_header(); the_post(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-help-center.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_<?php the_title(); ?></h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container">
      <?php the_content(); ?>
    </div>
<?php get_footer(); ?>
