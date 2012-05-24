<? if (!isset($id)) $id = 'sample';?>
<script type="text/javascript">
function preload(imgs){
   imgs = [
<? foreach($files as $key => $file): ?>
  "/img/albums/<?=$id?>/<?= $file ?>",
<? endforeach; ?>
   ];

  var objArray = [];
  for(var i = 0; i < imgs.length; i++){
    var imgObj = new Image();
    imgObj.src = imgs[i];
    objArray.push(imgObj);
  }
  var viewStatus = function(){
    var count = 0;
    var str = "";
    for(var i = 0; i < objArray.length; i++){
      if(objArray[i].complete) count++;
    }
    str += objArray.length + "件中" + count + "件完了";
    if(count == objArray.length){
      str += ":すべて完了しました。"
    }
    var viewElem = document.getElementById("view");
    if(viewElem) viewElem.innerHTML = str;
    if(count < objArray.length){
      setTimeout(viewStatus, 300);
    }
  };
  viewStatus();

}

function animation_start(){
  var element = $(".slideshow")[0];
  element.innerHTML="";
  if(element.className=="slideshow") {
    if(element.style.webkitAnimationPlayState == 'running'){
      element.style.webkitAnimationPlayState="paused";
    }else{
      element.style.webkitAnimationPlayState="running";
    }
  }
  $(".slideshow").bind("webkitAnimationEnd",function(){ 
    this.style.backgroundImage='url("/img/albums/<?=$id?>/<?=$files[100]?>")';
    this.innerHTML="<img src='/img/replay_button.png'>";
    this.style.webkitAnimationPlayState="paused";
  });
}
</script>

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
  -webkit-animation-duration: <?=(isset($album['Album']['play_speed']))?$album['Album']['play_speed']:'10'?>s;
  -webkit-animation-timing-function: step-start;
  -webkit-animation-play-state: paused;
  -webkit-animation-iteration-count: 1;
  -webkit-animation-direction: alternate;
}
</style>
<div id="view">画像の読み込み中です…</div>
<!-- 再生ボタン画像位置は無理やりstyle直書きで設定してますので治しちゃってください -->
<div class="slideshow" id='slideshow' onclick="animation_start()" style="text-align:center; padding-top:150px;"><?=$this->Html->image('btn_play.png');?></div>

