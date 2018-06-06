<?php

$event_id_dl = get_post_meta($id_dl, 'event', true);

if ($event_id_dl
  && in_array(get_post_meta($event_id_dl, 'status', true), array('started', 'ending'))
  && !in_array($event_id_dl, get_user_meta(get_current_user_id(), 'attend_events') ?: array())
):
  if (get_field('attend_event_review', $id_dl)):
    if (!in_array($id_dl, get_user_meta(get_current_user_id(), 'attend_event_review') ?: array())): ?>
    <a href="<?=get_permalink(get_page_by_path('user-center')->ID)?>?attend-event-review=<?=$id_dl?>" class="attend-event-review btn btn-outline-primary mx-auto d-block btn-common mb-4"><?=__('申请报名', 'young-bird')?></a>
    <?php else: ?>
    <button type="button" disabled class="btn btn-outline-primary mx-auto d-block btn-common mb-4 attend-activity"><?=__('已申请报名', 'young-bird')?></button>
    <?php
    endif;
  else: ?>
    <a href="<?=get_the_permalink($event_id_dl)?>" class="btn btn-outline-primary mx-auto d-block btn-common mb-4"><?=__('立即报名', 'young-bird')?></a>
  <?php
  endif;
endif; ?>
<?php if (get_field('attendable', $id_dl)): if (in_array($id_dl, get_user_meta(get_current_user_id(), 'attend_activities') ?: array())): ?>
  <button type="button" disabled class="btn btn-outline-primary mx-auto d-block btn-common mb-4 attend-activity"><?=__('已报名', 'young-bird')?></button>
<?php else: ?>
  <a href="<?=get_permalink(get_page_by_path('user-center')->ID)?>?attend-activity=<?=$id_dl?>" class="btn btn-outline-primary mx-auto d-block btn-common mb-4 attend-activity"><?=__('立即报名', 'young-bird')?></a>
<?php endif; endif; ?>
<?php if (get_field('recruitment', $id_dl)): if (in_array($id_dl, get_user_meta(get_current_user_id(), 'apply_jobs') ?: array())): ?>
  <button type="button" disabled class="btn btn-outline-primary mx-auto d-block btn-common mb-4 attend-activity"><?=__('已投递简历', 'young-bird')?></button>
<?php else: ?>
  <a href="<?=get_permalink(get_page_by_path('user-center')->ID)?>?recruitment=<?=$id_dl?>" class="btn btn-outline-primary mx-auto d-block btn-common mb-4 apply-joy"><?=__('投递简历', 'young-bird')?></a>
<?php endif; endif; ?>
