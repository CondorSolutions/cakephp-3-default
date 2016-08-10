<?php 
	use Cake\Core\Configure;
	use App\Util\OptionsUtil;
?>
<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>
    	<?= $this->fetch('title') ?> : <?= OptionsUtil::getOption(OptionsUtil::APP_NAME)->value1?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('metro/metro.css') ?>
    <?= $this->Html->css('metro/metro-icons.css') ?>
    <?= $this->Html->css('metro/metro-responsive.css') ?>
     <?= $this->Html->css('app.css') ?>
    
    
    
    <?= $this->Html->script('metro/ga.js') ?>
    <?= $this->Html->script('metro/jquery-2.1.3.min.js') ?>
    <?= $this->Html->script('metro/jquery.dataTables.min.js') ?>
    <?= $this->Html->script('metro/metro.js') ?>
    <?= $this->Html->script('metro/select2.min.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
 
    <style>
        .login-form {
            width: 25rem;
            position: fixed;
            top: 50%;
            margin-top: -9.375rem;
            left: 50%;
            margin-left: -12.5rem;
            background-color: #ffffff;
            opacity: 0;
            -webkit-transform: scale(.8);
            transform: scale(.8);
        }
    </style>

    <script>

       


        $(function(){
            var form = $(".login-form");

            form.css({
                opacity: 1,
                "-webkit-transform": "scale(1)",
                "transform": "scale(1)",
                "-webkit-transition": ".5s",
                "transition": ".5s"
            });
        });
    </script>
</head>
<body class="bg-darkTeal">
	<?= $this->Flash->render() ?>
	<?= $this->fetch('content') ?>
</body>
</html>