<?= $this->Html->docType('html5') ?>
<?= $this->Html->charset('utf-8') ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<title></title>

<!-- Le styles -->
<?//= $this->Html->css('bootstrap') ?>
<?//= $this->Html->css('bootstrap-responsive') ?>
<?//= $this->Html->css('docs') ?>
<?= $this->Html->css('style') ?>
<link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

<link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-responsive.min.css">
<!--[if lt IE 7]><link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-ie6.min.css"><![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link rel="stylesheet" href="http://blueimp.github.com/cdn/css/bootstrap-image-gallery.min.css">

<?= $scripts_for_layout ?>

<body data-spy="scroll" data-target=".subnav" data-offset="50">
  <div id="wrapper"><div class="inner">
<?= $this->element('nav') ?>
<?//= $this->element('header') ?>
<?= $content_for_layout ?>
<?= $this->element('footer') ?>
<?= $this->element('google_analytics') ?>
  </div></div>
</body>
