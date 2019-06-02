<?php get_header(); the_post(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/aboutus.jpg) center center / cover no-repeat">
      <div class="container">
        <h1></h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container page-editor mt-5">
      <?php the_content(); ?>
    </div>
<?php get_footer(); ?>
