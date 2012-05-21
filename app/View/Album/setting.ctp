<h1><?=$album['Album']['name']?>アルバム設定</h1>

<?= $this->Form->create(  'Album',  array(    'type' => 'post',    'url' => '/album/setting/'.$id  )) ?>
    
アルバム再生速度<br />
<?= $this->Form->range('Album.speed', array('max'=>100, 'min'=>1)) ?><br />

<?= $this->Form->radio('Album.public', array('1'=> '全公開', '2'=>'友達のみ', '3'=>'非公開'), array('legend'=>'公開設定', 'separator'=>' ')) ?><br />

    <?= $this->Form->submit('変更'); ?>    <?= $this->Form->end(); ?>
    
<?= $this->Html->link('戻る', '/album/detail/1') ?><br />
<br />
