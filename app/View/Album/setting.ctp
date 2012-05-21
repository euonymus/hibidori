<script type="text/javascript">
function changeValue(value) {
    document.getElementById("val").innerHTML = value;
}
</script> 
<h1><?=$album['Album']['name']?>アルバム設定</h1>

<?= $this->Form->create(  'Album',  array(    'type' => 'post',    'url' => '/album/setting/'.$id  )) ?>
<?=($updated)?'データを保存しました<br />':'';?>
アルバム再生速度<br /><span id="val"><?=(isset($album['Album']['play_speed']))?$album['Album']['play_speed']:10;?></span>秒<br />
<?= $this->Form->range('Album.play_speed', array('max'=>100, 'min'=>1, 'onchange' => 'changeValue(this.value)', 'value'=>(isset($album['Album']['play_speed']))?$album['Album']['play_speed']:10)) ?><br />

<?= $this->Form->radio('Album.public', array('1'=> '全公開', '2'=>'友達のみ', '3'=>'非公開'), array('legend'=>'公開設定', 'separator'=>' ', 'value'=>(isset($album['Album']['public']))?$album['Album']['public']:1)) ?><br />

    <?= $this->Form->submit('変更'); ?>    <?= $this->Form->end(); ?>
    
<?= $this->Html->link('戻る', '/album/detail/'.$id) ?><br />
<br />