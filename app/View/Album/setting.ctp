<script type="text/javascript">
function changeValue(value) {
    document.getElementById("val").innerHTML = value;
}
</script> 
<h1><?=$album['Album']['name']?>アルバム設定</h1>

<?= $this->Form->create(
  'Album',
  array(
    'type' => 'post',
    'url' => '/album/setting/'.$id,
    'class'=>'setting'
  )
) ?>
<?=($updated)?'データを保存しました<br />':'';?>
アルバム名<br />
<?= $this->Form->text('Album.name', array('value'=>$album['Album']['name'], 'label' => 'アルバム名：', 'class' => 'formtext', 'error' => array(
      'empty' => 'アルバム名は必須入力です。',
      'length' => 'アルバム名は＜全角半角1~255字＞でお願いします。',
      'valid'=>'アルバム名には機種依存文字を使用できません。（例：①Ⅰ㈱）',
      'attack'=>'不正な文字列が入力されました。' ))); ?><br />
アルバム再生速度<br /><span id="val"><?=(isset($album['Album']['play_speed']))?$album['Album']['play_speed']:10;?></span>秒(1~100)<br />
<?= $this->Form->range('Album.play_speed', array('max'=>100, 'min'=>1, 'onchange' => 'changeValue(this.value)', 'value'=>(isset($album['Album']['play_speed']))?$album['Album']['play_speed']:10, 'class'=>'range')) ?><br />

<?= $this->Form->radio('Album.public', array('0'=>'非公開', '1'=> '公開'), array('legend'=>'公開設定', 'separator'=>' ', 'value'=>(isset($album['Album']['public']))?$album['Album']['public']:0, 'class'=>'radio')) ?><br />

    <?= $this->Form->submit('変更'); ?> 
    <?= $this->Form->button('戻る', array('type'=>'button','onClick'=>"location.href='/album/detail/".$id."';", 'class'=>'button')); ?>
    <?= $this->Form->end(); ?>
