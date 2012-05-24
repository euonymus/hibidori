<script>
$(function() {
	$(".overlay").css({
	opacity: '0.6',
	position: 'absolute',
	top: '0',
	left: '0',
	width: '100%',
	height: '100%',
	});
	$(".person").click(function() {
		$(".overlay").css('background', 'url(/img/overlay_person.png) no-repeat 0 0');
		$(".overlay").css('background-position', 'center center');
	});
	$(".lastshoot").click(function() {
		$(".overlay").css('background', 'url(/img/albums/<?=$id?>/<?=$lastfile?>) no-repeat 0 0');
		$(".overlay").css('background-position', 'center center');
	});
});
</script>

<ul>
  <li>
    <a href="#"><?= $this->Html->image('shoot01.png')?>
    <div style="float:left;"><a class="person" href="#"><?= $this->Html->image('overlay_person_button.png')?></a></div>
    <div style="float:none;"><a class="lastshoot" href="#"><?= $this->Html->image('overlay_lastshoot_button.png')?></a></div>
    <div class="overlay"></div>
  </li>
</ul>

  <?= $this->Form->create('Album', array('enctype' => 'multipart/form-data', 'action' => 'upload','class' => 'form', 'type' => 'post', 'url' => $this->here)) ?>

<?/* if(isset($this->data['Album']['id'])){ ?>
<img src="/img/albums/<?= $this->data['Album']['id'] ?>" />
<? } */?>

<?= $this->Form->input('Album.shoot_image', array('type' => 'file', 'label'=>'')) ?>
<?= $this->Form->error('banner') ?>

  <?=$this->Form->end('保存')?>

