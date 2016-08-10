<?php 
use Cake\Core\Configure;
use App\Util\OptionsUtil;
?>
	 <div class="app-bar fixed-top darcula" data-role="appbar">
        <a class="app-bar-element branding"><?OptionsUtil::getOption(OptionsUtil::APP_NAME)->value1?></a>
        <span class="app-bar-divider"></span>
        <ul class="app-bar-menu">
            <li><a href="">Dashboard</a></li>
            <!-- 
            <li>
                <a href="" class="dropdown-toggle">Project</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="">New project</a></li>
                    <li class="divider"></li>
                    <li>
                        <a href="" class="dropdown-toggle">Reopen</a>
                        <ul class="d-menu" data-role="dropdown">
                            <li><a href="">Project 1</a></li>
                            <li><a href="">Project 2</a></li>
                            <li><a href="">Project 3</a></li>
                            <li class="divider"></li>
                            <li><a href="">Clear list</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="">Security</a></li>
            <li><a href="">System</a></li>
             -->
            <li>
                <a href="" class="dropdown-toggle">Help</a>
                <ul class="d-menu" data-role="dropdown">
                    <li><a href="">About</a></li>
                </ul>
            </li>
        </ul>
<?php 
	//$this->log($authUser['roles'][0]['_joinData']['role_id']);
	//$this->log($roles);
?>
<!-- 
        <div class="app-bar-element place-right">
            <span class="dropdown-toggle"><span class="mif-cog"></span> <?php echo $loggedUser['full_name'] ; ?></span>
            <div class="app-bar-drop-container padding10 place-right no-margin-top block-shadow fg-dark" data-role="dropdown" data-no-close="true" style="width: 220px">
                <h2 class="text-light"><?php echo $loggedUser['full_name'] ;?></h2>
                <h4><?php echo '(' .  $roles[$authUser['roles'][0]['_joinData']['role_id']]  . ')'?></h4>
                <ul class="unstyled-list fg-dark">
                    <li><a href="<?php echo $this->request->webroot;?>users/edit/<?php echo $loggedUser['id'];?>" class="fg-white1 fg-hover-yellow">Profile</a></li>
                    <li><?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout']) ?></li>
                </ul>
            </div>
        </div>
         -->
    </div>