<style>
li {
  display:inline;float:left;
  margin-right:10px;
  position:relative;
}
.overlay {
  position:absolute;
  top:0;
  left:0;
  width:400px;
  height:400px;
  background:url(/img/overlay_person.png) no-repeat 0 0;
  opacity: 0;
  -webkit-transition: opacity .25s linear;
  -moz-transition: opacity .25s linear;
  -o-transition: opacity .25s linear;
  transition: opacity .25s linear;
  /* IE7 */
 filter: alpha(opacity=0);
  /* IE8 */
  -ms-filter:
  "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  z-index:0;
}
.overlay:hover {
  opacity: 1;
  /* IE7 */
  filter: alpha(opacity=75);
  /* IE8 */
  -ms-filter:
  "progid:DXImageTransform.Microsoft.Alpha(Opacity=75)";
}
</style>

<ul>
  <li>
     <a href="#"><?= $this->Html->image('shoot01.png')?>
     <span class="overlay"></span></a>
  </li>
</ul>

  <?= $this->Form->create('Album', array('enctype' => 'multipart/form-data', 'action' => 'upload','class' => 'form', 'type' => 'post', 'url' => $this->here)) ?>

<?/* if(isset($this->data['Album']['id'])){ ?>
<img src="/img/albums/<?= $this->data['Album']['id'] ?>" />
<? } */?>

<?= $this->Form->input('Album.shoot_image', array('type' => 'file', 'label'=>'')) ?>
<?= $this->Form->error('banner') ?>

  <?=$this->Form->end('保存')?>

