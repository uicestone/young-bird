    <!-- Footer -->
    <div class="footer">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="share">
              <a class="button-tsina" href="https://weibo.com/youngbirdplan" target="_blank"></a>
              <a class="button-weixin">
                <div>
                  <img src="<?=get_stylesheet_directory_uri()?>/images/wechat-qr.png" alt="">
                </div>
              </a>
            </div>
            <ul class="list-inline">
              <li class="list-inline-item mx-2">
                <a href="<?=pll_home_url()?>about-us/"><?=__('关于我们', 'young-bird')?></a>
              </li>
              <li class="list-inline-item mx-2">
                <a href="<?=pll_home_url()?>business-cooperation/"><?=__('商务合作', 'young-bird')?></a>
              </li>
              <li class="list-inline-item mx-2">
                <a href="<?=pll_home_url()?>help-center/"><?=__('帮助中心', 'young-bird')?></a>
              </li>
            </ul>
          </div>
          <div class="col-lg-16 contact d-none d-lg-flex">
            <span class="mr-md-4">TELEPHONE & FAX&nbsp;&nbsp;+86 021 6258 5617&nbsp;&nbsp;+86 021 6258 5617-102</span>
            <span class="nowrap">E-MAIL&nbsp;&nbsp;competition@youngbird.com.cn</span>
            <span class="nowrap">沪ICP备 16055号-1|© 2016-2018 Design Verse <?=__('版权所有', 'young-bird')?></span>
          </div>
          <div class="col-lg-16 contact d-lg-none">
            <div>TELEPHONE & FAX<br />+86 021 6258 5617<br />+86 021 6258 5617-102</div>
            <div class="nowrap">E-MAIL<br />competition@youngbird.com.cn</div>
            <div class="nowrap">沪ICP备16034585号-2 |© 2016-2018 Design Verse <?=__('版权所有', 'young-bird')?></div>
          </div>
        </div>

      </div>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>
