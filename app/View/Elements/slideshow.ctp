<? if (!isset($id)) $id = 'sample';?>
<style>
.slideshow {
<?= $this->Html->style(array(
    'width'     => '260px',
    'height' => '344px',
    'background-repeat' => 'no-repeat',
    'background-image' => 'url("/img/albums/' . $id . '/' . $files[0] . '")'
)); ?>
}

@-webkit-keyframes 'slideAnimation' {
<? foreach($files as $key => $file): ?>
  <?= $key ?>% { background-image: url("/img/albums/<?=$id?>/<?= $file ?>"); }
<? endforeach; ?>
}

.slideshow {
  -webkit-animation-name: slideAnimation;
  -webkit-animation-duration: 10.0s;
  -webkit-animation-play-state: paused
}
.slideshow:hover {
  -webkit-animation-timing-function: step-start;
  -webkit-animation-play-state: running;
}
</style>
<div class="slideshow"></div>
