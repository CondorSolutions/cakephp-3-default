<?php 
	use Cake\Core\Configure;
	use App\Util\OptionsUtil;
?>
<!DOCTYPE html>
<html>
<head>
      <title>
    	<?= $this->fetch('title') ?> : <?= OptionsUtil::getOption(OptionsUtil::APP_NAME)->value1 ?>
    </title>
	<?= $this->Html->meta('icon') ?>
	
    <?= $this->Html->css('metro/metro.css') ?>
    <?= $this->Html->css('metro/metro-icons.css') ?>
    <?= $this->Html->css('metro/metro-responsive.css') ?>
    <?= $this->Html->css('app.css') ?>
    

    <style>
        html, body {
            height: 100%;
        }
        body {
        }
        .page-content {
            padding-top: 3.125rem;
            min-height: 100%;
            height: 100%;
        }
        .table .input-control.checkbox {
            line-height: 1;
            min-height: 0;
            height: auto;
        }

        @media screen and (max-width: 800px){
            #cell-sidebar {
                flex-basis: 52px;
            }
            #cell-content {
                flex-basis: calc(100% - 52px);
            }
        }
        .table{
        	border: solid 1px;
        }
        
        
    </style>

  
</head>
<body class="">
  <?= $this->fetch('content') ?>
</body>
</html>
