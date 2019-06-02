    <!-- Footer -->
    <div class="footer">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="share">
              <a class="button-share-item button-tsina" href="https://weibo.com/youngbirdplan" target="_blank"></a>
              <a class="button-share-item button-weixin">
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
            <span class="mr-md-4"><a href="http://www.beian.miit.gov.cn">沪ICP备16034585号-2</a> | © 2016-2018 Young Bird Plan <?=__('版权所有', 'young-bird')?></span>
            <span class="nowrap"><button class="yyzz_modal" data-toggle="modal" data-target="#yyzz" type="button">营业执照</button></span>
            <span>
              <a href="https://218.242.124.22:8082/businessCheck/verifKey.do?showType=extShow&serial=9031000020171214160003000002250622-SAIC_SHOW_310000-4028e4cb641aec46016475dd2de00892836&signData=MEQCIEJ5sIa687E58bcQ9ng7oLLsSkFyVWzH2sUg8tjoUVROAiB8k2v72LzyF9KdfRPpTpMklxzK5YnRrxSog5ETffJT2Q==">
                <img src="/img/lz2.jpg" class="img-fluid" style="width: 24px;margin-left: 10px;">
              </a>
            </span>
          </div>
          <div class="col-lg-16 contact d-lg-none">
            <div>TELEPHONE & FAX<br />+86 021 6258 5617<br />+86 021 6258 5617-102</div>
            <div class="nowrap">E-MAIL<br />competition@youngbird.com.cn</div>
            <div class="nowrap"><a href="http://www.beian.miit.gov.cn">沪ICP备16034585号-2</a> <br /> © 2016-2018 Young Bird Plan <?=__('版权所有', 'young-bird')?></div>
            <div class="nowrap"><button class="yyzz_modal" data-toggle="modal" data-target="#yyzz" type="button">营业执照</button></div>
            <div class="nowrap">
              <a href="https://218.242.124.22:8082/businessCheck/verifKey.do?showType=extShow&serial=9031000020171214160003000002250622-SAIC_SHOW_310000-4028e4cb641aec46016475dd2de00892836&signData=MEQCIEJ5sIa687E58bcQ9ng7oLLsSkFyVWzH2sUg8tjoUVROAiB8k2v72LzyF9KdfRPpTpMklxzK5YnRrxSog5ETffJT2Q==">
                <img src="/img/lz2.jpg" class="img-fluid" style="width: 24px;margin-left: 10px;">
              </a>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="yyzz">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <img class="img-fluid" src="/img/yyzz.jpg">
        </div>
      </div>
    </div>

    <?php wp_footer(); ?>
  </body>
</html>
