<?php get_header(); the_post(); ?>
    <!-- Banner -->
    <div class="container-fluid judge-detail" style="padding: 0;background: #c8c8c8">
      <div class="container banner d-flex py-4">
        <div class="avatar">
          <?php the_post_thumbnail('medium-sq'); ?>
        </div>
        <div class="desc pl-3 pl-lg-5">
          <h1 class="color-black font-weight-bold mb-4"><?php the_title(); ?></h1>
          <?php foreach (array_slice(explode("\n", $post->post_excerpt), 0, 2) as $line): ?>
          <p><?=$line?></p>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <!-- Body -->
    <div class="judge-detail">
      <div class="container mt-3 mt-lg-6 pb-7">
        <div class="editor">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
<?php get_footer(); ?>
