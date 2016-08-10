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
    	<?= $this->fetch('title') ?> : <?=OptionsUtil::getOption(OptionsUtil::APP_NAME)->value1 ?>
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
    
    <?= $this->Html->script('app.js') ?>
    <?= $this->Html->script('user.js') ?>
    <?= $this->Html->script('address.js') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

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
    </style>

    <script>
    	var webroot = '<?php echo $this->request->webroot;?>';
        function pushMessage(t){
            var mes = 'Info|Implement independently';
            $.Notify({
                caption: mes.split("|")[0],
                content: mes.split("|")[1],
                type: t
            });
        }

        $(function(){
            $('.sidebar').on('click', 'li', function(){
                if (!$(this).hasClass('active')) {
                    $('.sidebar li').removeClass('active');
                    $(this).addClass('active');
                }
            })
        })
    </script>
</head>
<body class="bg-steel">
   <?php echo $this->element('Menus/menu_top_public');?>
    <div class="page-content" style="height: 110%">
        <div class="flex-grid no-responsive-future" style="height: 100%;">
            <div class="row" style="height: 100%">
            	<!-- 
                <div class="cell size-x200" id="cell-sidebar" style="background-color: #71b1d1; height: 100%">
                    <?php //echo $this->element('Menus/menu_side');?>
                </div>
                 -->
                <div class="cell auto-size padding20 bg-white" id="cell-content">
                		<?= $this->Flash->render() ?>
                		<?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>