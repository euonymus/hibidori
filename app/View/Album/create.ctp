<section class="createnew">  <h1>新しいアルバムをつくる</h1>    <div class="create">    <?= $this->Form->create(      'Album',      array(        'type' => 'post',        'url' => '/album/create'      )    ) ?><?= $this->Form->input('Album.name', array( 'label' => 'アルバム名：', 'class' => 'formtext', 'error' => array(      'empty' => 'アルバム名は必須入力です。',      'length' => 'アルバム名は＜全角半角1~255字＞でお願いします。',      'valid'=>'アルバム名には機種依存文字を使用できません。（例：①Ⅰ㈱）',      'attack'=>'不正な文字列が入力されました。' ))); ?>    <div class="button"><?= $this->Form->submit('次へ'); ?></div>    <?= $this->Form->end(); ?>    </div></section>