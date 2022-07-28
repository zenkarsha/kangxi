<?php

class imageController extends View
{
  var $model;
  function __construct ()
  {
    include './system/controller/partial/__construct.php';
  }
}
class ajax extends imageController
{
  function __construct()
  {
    parent::__construct();

    include './system/class/createImage.php';

    //post attribute
    @$usertext = $_POST['usertext'];
    @$vertical = $_POST['vertical'];
    @$shadow = $_POST['shadow'];
    @$styleandform = $_POST['styleandform'];
    @$sizeandform = $_POST['sizeandform'];
    @$directpost = 2;

    //create object
    $obj = new createImage();
    $obj -> Create($usertext, $vertical, $shadow, $styleandform, $sizeandform,$directpost);
  }
}
class kxgen extends imageController
{
  function __construct()
  {
    parent::__construct();

    include './system/class/createImage.php';

    //post attribute
    @$usertext = $_POST['usertext'];
    @$vertical = $_POST['vertical'];
    @$shadow = $_POST['shadow'];
    @$styleandform = $_POST['styleandform'];
    @$sizeandform = $_POST['sizeandform'];
    @$directpost = $_POST['directpost'];

    //create object
    $obj = new createImage();
    $obj -> Create($usertext, $vertical, $shadow, $styleandform, $sizeandform,$directpost);
  }
}
class facebookpost extends imageController
{
  function __construct()
  {
    parent::__construct();

    if(isset($_GET['photo'])) {
      $photo = "./temp/".$_GET['photo'].".png";
      if(file_exists($photo)) {
        require_once('./system/extension/php-sdk/facebook.php');

        $config = array(
          'appId' => '208520365982183',
          'secret' => '05ab532c6c14753c291d0549674ef623',
          'fileUpload' => true,
        );

        $facebook = new Facebook($config);
        $user_id = $facebook->getUser();

        if($user_id) {
          try {
            $user = $facebook->api('/'.$user_id.'/?fields=albums.fields(id,name)');
            $albums=$user['albums']['data'];
            for($i=0;$i<count($albums);$i++) {
              if($albums[$i]['name']=='Timeline Photos') {
                $timelinealbumid=$albums[$i]['id'];
                break;
              }
            }
            $ret_obj = $facebook->api('/'.$timelinealbumid.'/photos', 'POST', array('source' => '@' . $photo));
            //redirect to users facebook
            $url="https://www.facebook.com/".$user_id;
            header("Location: $url");
          } catch(FacebookApiException $e) {
          $login_url = $facebook->getLoginUrl( array('scope' => 'user_photos,photo_upload'));

            error_log($e->getType());
            error_log($e->getMessage());
            header("Location: $login_url");
          }
        } else {
          $login_url = $facebook->getLoginUrl( array( 'scope' => 'user_photos,photo_upload') );
          //echo '<a href="' . $login_url . '">plz login</a>';
          header("Location: $login_url");
        }
      } else {
        $url = $this->config['site']['path'];
        header("Location: $url");
      }
    } else {
      $url = $this->config['site']['path'];
      header("Location: $url");
    }
  }
}
?>
