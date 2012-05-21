<?/*<a href="/album/detail/<?=$id;?>" class="shoot1"><?= $this->Html->image('/img/shoot01.png', array('alt' =>'あると')) ?></a><br />*/?>

  <?= $this->Form->create('Album', array('enctype' => 'multipart/form-data', 'action' => 'upload','type' => 'post', 'url' => $this->here)) ?>
<?/* if(isset($this->data['Album']['id'])){ ?>
<img src="/img/albums/<?= $this->data['Album']['id'] ?>" />
<? } */?>

<?= $this->Form->input('Album.shoot_image', array('type' => 'file', 'label'=>'')) ?>
<?= $this->Form->error('banner') ?>

    <?=$this->Form->end('保存')?>
  <?=$this->Form->end()?>

