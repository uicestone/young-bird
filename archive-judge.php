<?php get_header(); ?>
    <!-- Banner -->
    <div class="container-fluid sub-banner p-0" style="background: url(<?=get_stylesheet_directory_uri()?>/images/banner-partners.jpg) center center / cover no-repeat">
      <div class="container">
        <h1>_大 咖 <br>JUDGE CENTER</h1>
      </div>
    </div>
    <!-- Body -->
    <div class="container mt-32 mt-md-7 pb-4 pubu">
      <div class="row mx-auto pubu-list">
        <?php while (have_posts()): the_post(); ?>
        <a href="<?php the_permalink(); ?>" class="col-12 col-md-8 col-lg-6 mb-4 mb-md-5 link item-judge-container">
          <div class="card item-judge">
            <div>
            <?php the_post_thumbnail('medium-sq', array ('class' => 'card-img-top')); ?>
            </div>
            <div class="card-body mt-3 mt-md-4">
              <h5><?php the_title(); ?></h5>
              <div class="excerpt">
                <?php foreach (array_slice(explode("\n", $post->post_excerpt), 0, 2) as $line): ?>
                <p class="text-truncate mb-0" title="<?=$line?>"><?=$line?></p>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </a>
        <?php endwhile; ?>
      </div>
      <!-- <button type="button" class="btn btn-outline-primary mx-auto d-block btn-common mb-4 btn-loadmore" data-name="judge"><?=__('更多导师', 'young-bird')?></button> -->
      <nav class="mt-5">
        <?=paginate_links(array ('type' => 'list', 'prev_text' => '<i class="fas fa-angle-left"></i>', 'next_text' => '<i class="fas fa-angle-right"></i>', 'before_page_number' => '0'))?>
      </nav>
    </div>
<?php get_footer(); ?>
