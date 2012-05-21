<div class="user-profile">
  <a href="/profile/<?= $twuser['Twuser']['screen_name'] ?>" class="user-img"><?= $this->Html->image($twuser['Twuser']['profile_image_url'], array('alt' =>$twuser['Twuser']['name'], 'width' => '45px', 'height' => '45px')) ?></a>
  <span class="name"><?= $this->Html->link($twuser['Twuser']['name'], '/profile/' . $twuser['Twuser']['screen_name']) ?>さんのアルバム一覧</span>
</div>

<section>
  <ul class="timeline">
<? foreach($albums as $album) : ?>
    <li><a href="/album/detail/<?= $album['Album']['id'] ?>"><?= $this->Html->image('/img/albums/' . $album['Album']['id'] . '/00001.jpg', array('alt' => $album['Album']['name'], 'width'=>'45px', 'height'=>'45px')) ?></a></li>
<? endforeach; ?>
  </ul>
</section>
