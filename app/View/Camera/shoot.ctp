<script>
$(function() {
	$(".overlay").css({
	position: 'absolute',
	top: '50px',
	left: '0',
	width: '100%',
	height: '100%',
	});
	$(".person").click(function() {
		$(".overlay").css('background', 'url(/img/overlay_person.png) no-repeat 0 0');
		$(".overlay").css('background-position', 'center -40px');
		$(".overlay").css('opacity', '1');
	});
<? if(!is_null($lastfile)): ?>
  $(".lastshoot").click(function() {
		$(".overlay").css('background', 'url(/img/albums/<?=$id?>/<?=$lastfile?>) no-repeat 0 0');
		$(".overlay").css('background-position', 'center 0');
		$(".overlay").css('opacity', '0.3');
	});
<? endif; ?>
	$(".grid").click(function() {
		$(".overlay").css('background', 'url(/img/grid.png) no-repeat 0 0');
		$(".overlay").css('background-position', 'center -40px');
		$(".overlay").css('opacity', '1');
	});
	$(".off").click(function() {
		$(".overlay").css('background-image', 'url()');
	});
});
</script>

    <?= $this->Html->image('shoot01.png')?>
    <ul class="camera-nav">
      <li><a class="person" href="#">人物</a></li>
      <li><a class="lastshoot" href="#">風景</a></li>
      <li><a class="grid" href="#">グリッド表示</a></li>
      <li><a class="off" href="#">オフ</a></li>
    </ul>
    <div class="overlay"></div>


  <?= $this->Form->create('Album', array('enctype' => 'multipart/form-data', 'action' => 'upload','class' => 'form', 'type' => 'post', 'url' => $this->here)) ?>

<?/* if(isset($this->data['Album']['id'])){ ?>
<img src="/img/albums/<?= $this->data['Album']['id'] ?>" />
<? } */?>

<?= $this->Form->input('Album.shoot_image', array('type' => 'file', 'label'=>'')) ?>
<?= $this->Form->error('banner') ?>

  <?=$this->Form->end('保存')?>

