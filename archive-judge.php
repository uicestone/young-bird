<?php get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-partners.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_大 咖 <br>PARTNERS</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-7 pb-4">
      <div class="row">
        <?php while (have_posts()): the_post(); ?>
        <a href="<?php the_permalink(); ?>" class="col-sm-12 col-md-8 col-lg-6 mb-5 link">
          <div class="card item-judge">
            <?php the_post_thumbnail('medium-sq', array ('class' => 'card-img-top')); ?>
            <div class="card-body mt-4">
              <h5><?php the_title(); ?></h5>
              <p><?php the_excerpt(); ?></p>
            </div>
          </div>
        </a>
        <?php endwhile; ?>
      </div>
    </div>
<?php get_footer(); ?>
