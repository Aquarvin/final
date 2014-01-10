<html>
<head>
<title> Application Notes </title>
<meta charset="utf-8"/>
    <!-- Le styles -->
    <link href="./css/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="./css/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
</head>
<body>
<?php
      $classHome= '';
      $classCreate= '';
      $action = $this->getAction()->getID();

      switch ($action) {
        case 'index':
              $body_title = 'Notes list';
              $classHome = "active";
          break;
        case 'author':
            $actionParams=$this->getActionParams();
            $body_title = 'Author\'s Notes list';
          break;
        case 'create':
            $body_title = 'Creat new note';
            $classCreate = "active";
          break;
        case 'view':  
            $body_title = 'Note';
          break;
        case 'edit':
            $body_title = 'Edit note';
          break; 
          case 'login':
            $body_title = 'Authorization';
          break;  
        case 'search':
            $actionParams=$this->getActionParams();
            $body_title = 'Search results';
          break; 
          default:
            $body_title = $action;
            break;     
      }
?>
<form class="nav" action="index.php" method="GET">
<div class="navbar">
  <div class="navbar-inner">
      <a class="brand"><?echo Yii::t('main','Note');?></a>
      <ul class="nav inline">
       <li class=<?=$classHome;?>><a href="index.php"><?echo Yii::t('main','Home');?></a></li>
       <li class=<?=$classCreate;?>><? echo CHtml::link(CHtml::encode(Yii::t('main','Create')),array('create')); ?></li>
       <li><input type="text" name="search" class="search-query" placeholder=<?echo '"'.Yii::t('main','Search').'"';?>></li>
       <li><button type="submit" name="r"class="btn" value="note/search"><?echo Yii::t('main','Search');?></button></li>
       <?if (!Yii::app()->user->isGuest):?>
        <li><a href=""> <? echo Yii::app()->user->name; ?> </a></li>
        <li><? echo CHtml::link(Yii::t('main','Logout'),array('note/logout',));?></li>
       <?else:?>
        <li><? echo CHtml::link(Yii::t('main','Login'),array('note/login',));?></li>
        <?endif?>
      </ul>
  </div>
</div>
</form>
<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="alert alert-' . $key . '">' . $message . "</div>\n";
    }
?>

<fieldset class="content">
<legend style="text-align: left;"><?echo Yii::t('main',$body_title).(isset($actionParams[$action])?": '".$actionParams[$action]."'":'');?></legend>
<?php echo $content; ?>


</fieldset>
</body>
</html>