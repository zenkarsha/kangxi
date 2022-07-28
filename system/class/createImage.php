<?php

class createImage
{
  private $fontPath = './font/jellyfish20140617.ttf';
  function Create($usertext, $vertical, $shadow, $styleandform, $sizeandform,$directpost){

    $usertextFull=$usertext;

    if($vertical == 1) $vertical='true';
    if($usertext == '') {
$usertext=' 康熙字典體於此
 就是要你知道
 天下萬萬字體
 朕賜給你的
 才是你的
 朕不給的
 你自己來想辦法';
}

    $filename_text='kangxi-text';

    $font=$this->fontPath;
    $this->userText = $usertext;

    include_once './system/function/systemFunction.php';
    include_once './system/extension/kxgenEmojis.php';

    //get font size
    $fontSize=array('default'=>18,'bigger'=>24,'great'=>30,'omg'=>40,'omgless'=>80);
    $fontPadding=array('default'=>18,'bigger'=>24,'great'=>30,'omg'=>40,'omgless'=>60);
    $cutwords=array('default'=>42,'bigger'=>36,'great'=>30,'omg'=>24,'omgless'=>30);

    if($sizeandform !== null) {
      $uFont=$fontSize[$sizeandform];
      $uPadding=$fontPadding[$sizeandform];
    }
    else {
      $uFont=18;
      $uPadding=2;
    }

    $uStyle=$styleandform;

    //$text=strtoupper($this->userText);
    $text=$this->userText;
    $text=str2img($text);
    if($vertical == 'true') $text=$this->verticalText($text);

    $cutword = $cutwords[$sizeandform];

    if($vertical == 'true') $new_text=$this->getHeightVertical($text);
    else $new_text=$this->getHeight($text,$cutword);
    $filename_text=$this->getHeight($filename_text,$cutword);
    //remove empty elements
    if($vertical == 'true') $new_text=array_filter($new_text);

    $width=$this->getWidht($new_text)*($uFont/2)+$uPadding*2;
    $height=count($new_text)*($uFont+12)+$uPadding*2;
    $size=$uFont;
    $angle=0;

    $image = imagecreatetruecolor($width, $height);//create empty image
    $white = imagecolorallocate($image, 255, 255, 255);
    $grey = imagecolorallocate($image, 128, 128, 128);
    $dimGray = imageColorAllocate($image, 143,143,143);
    $black = imagecolorallocate($image, 0, 0, 0);
    $almostblack = imagecolorallocate($image, 1, 1, 1);
    $darkBlack=imagecolorallocate($image, 30, 30, 30);
    $red = ImageColorAllocate($image, 211,12,14);
    $blue = ImageColorAllocate($image, 0,86,184);
    $lightBlue = ImageColorAllocate($image, 83,162,229);
    $chinaRed = ImageColorAllocate($image, 255,43,2);
    $santaRed = ImageColorAllocate($image, 228,28,36);
    $yellow = ImageColorAllocate($image, 253,240,2);
    $fbpost = ImageColorAllocate($image, 246,247,248);

    if($uStyle == 'black')
    imagefilledrectangle($image, 0, 0, $width, $height, $black);
    elseif($uStyle == 'yellow')
    imagefilledrectangle($image, 0, 0, $width, $height, $yellow);
    elseif($uStyle == 'bluebg')
    imagefilledrectangle($image, 0, 0, $width, $height, $blue);
    elseif($uStyle == 'santa')
    imagefilledrectangle($image, 0, 0, $width, $height, $santaRed);
    elseif($uStyle == 'spring')
    imagefilledrectangle($image, 0, 0, $width, $height, $chinaRed);
    else
    {
      if($directpost == '19890930'){
        imagecolortransparent($image, $almostblack);
        imagefilledrectangle($image, 0, 0, $width, $height, $almostblack);
      }
      else
        imagefilledrectangle($image, 0, 0, $width, $height, $white);
    }


    //drawing background
    if($uStyle == 'ching'){
      $ching = imagecreatefrompng('images/bg/ching.png');
      $wcount=ceil($height/300);
      $hcount=ceil($width/296);

      for($i=0;$i<$wcount;$i++){
        for($j=0;$j<$hcount;$j++) {
          imagecopy($image, $ching, $j*296, $i*300, 0, 0, $width, $height);
        }
      }
    }
    elseif($uStyle == 'fly'){
      $fly = imagecreatefrompng('images/bg/bird.png');
      $wcount=ceil($height/206);
      $hcount=ceil($width/206);

      for($i=0;$i<$wcount;$i++){
        for($j=0;$j<$hcount;$j++) {
          imagecopy($image, $fly, $j*206, $i*206, 0, 0, $width, $height);
        }
      }
    }
    elseif($uStyle == 'wood'){
      $wood = imagecreatefrompng('images/bg/wood.png');
      $wcount=ceil($height/400);
      $hcount=ceil($width/400);

      for($i=0;$i<$wcount;$i++){
        for($j=0;$j<$hcount;$j++) {
          imagecopy($image, $wood, $j*400, $i*400, 0, 0, $width, $height);
        }
      }
    }

    //drawing text onto image
    $x=5;
    $y=25;
    if($shadow == 'true'){
      for($i=0;$i<count($new_text);$i++){
        imagettftext($image, $uFont, 0, $uPadding+6, $uPadding+($uFont+7)+($i*($uFont+12)), $grey, $font, $new_text[$i]);
      }
    }
    if($uStyle == 'gray')
    $fontColor=$dimGray;
    else if($uStyle == 'red')
    $fontColor=$red;
    else if($uStyle == 'black')
    $fontColor=$white;
    else if($uStyle == 'ching')
    $fontColor=$white;
    else if($uStyle == 'blue')
    $fontColor=$blue;
    else if($uStyle == 'fly')
    $fontColor=$lightBlue;
    else if($uStyle == 'santa')
    $fontColor=$white;
    else if($uStyle == 'bluebg')
    $fontColor=$white;
    else
    $fontColor=$black;

    //line by line
    for($i=0;$i<count($new_text);$i++){
      imagettftext($image, $uFont, 0, $uPadding+5, $uPadding+($uFont+7)+($i*($uFont+12)), $fontColor, $font, $new_text[$i]);
    }

    //create image
    switch ($directpost) {
      case 1:
        header('Content-Type: image/png');
        $filename=time();
        $save = "./temp/".$filename.".png";
        imagepng($image,$save,9,null);
        $url="facebookpost/?photo=".$filename;
        header("Location: $url");
        break;

      case 2:
        ob_start();
        imagepng($image,null,9,null);
        $image = ob_get_contents();
        ob_end_clean();
        @imagedestroy($image);
        print '<img src="data:image/png;base64,'.base64_encode($image).'"/>';
        break;

      case 19890930:

        for($i = $width; $i > 0; $i=$i-rand(1,30)) {
            for($j = $height; $j > 0; $j=$j-rand(1,90)) {

              //gray noise
              $noise = rand(30,100);
                $color = imagecolorallocate($image, $noise, $noise, $noise);

                //color noise
                //$color = imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255));

                imagesetpixel($image, $i, $j, $color);
                $noise_angle=rand(0,4);
                switch ($noise_angle) {
                  case 0: imagesetpixel($image, $i-1, $j+1, $color); break;
                  case 1: break;
                  case 2: break;
                  case 3: break;
                  case 4: break;
                }
            }
        }

        $filename=base64_encode($usertextFull).'yupei#930';
        $filename=hash('sha1',$filename);
        $save = "./ogimg/".$filename.".png";

        if(!file_exists($save))
        {

          $text_length=mb_strlen($text,'utf-8');

          if($text_length>16)
          {
            $text=mb_substr($text,0,1,"utf-8");
            $thumb_fontsize=100;
            $thumb_cutword=3;
          }
          elseif($text_length>9 && $text_length<=16)
          {
            $thumb_fontsize=26;
            $thumb_cutword=12;
          }
          elseif($text_length>4 && $text_length<=9)
          {
            $thumb_fontsize=35;
            $thumb_cutword=9;
          }
          elseif($text_length>1 && $text_length<=4)
          {
            $thumb_fontsize=52;
            $thumb_cutword=6;
          }
          elseif($text_length == 1)
          {
            $thumb_fontsize=100;
            $thumb_cutword=3;
          }

          //generate text image
          $thumb_text=$this->getHeight($text,$thumb_cutword);
          $thumb_width=$this->getWidht($thumb_text)*($thumb_fontsize/2);
          $thumb_height=count($thumb_text)*($thumb_fontsize+14);
          $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
          imagefilledrectangle($thumb, 0, 0, $thumb_width, $thumb_height, $fbpost);

          for($i=0;$i<count($thumb_text);$i++){
            imagettftext($thumb, $thumb_fontsize, 0, 0, ($thumb_fontsize+7)+($i*($thumb_fontsize+12)), $black, $font, $thumb_text[$i]);
          }

          //create background image
          $thumb_bg = imagecreatetruecolor(154,154);
          imagefilledrectangle($thumb_bg, 0, 0, 154, 154, $fbpost);

          //merge image
          $thumb_x=ceil((154-$thumb_width)/2);
          $thumb_y=ceil((154-$thumb_height)/2);
          imagecopymerge($thumb_bg,$thumb,$thumb_x,$thumb_y,0,0,$thumb_width,$thumb_height,100);

          imagepng($thumb_bg,$save,9,null);
          @imagedestroy($thumb);
        }

        ob_start();
        imagepng($image,null,9,null);
        $image = ob_get_contents();
        ob_end_clean();
        @imagedestroy($image);
        print '<img src="data:image/png;base64,'.base64_encode($image).'"/>';

        break;

      default:
        header('Content-Type: image/png');
        header("Content-Transfer-Encoding: binary");
        header('Content-Description: File Transfer');

        $filename=str_replace("@", "", $filename_text[0]);
        header('Content-Disposition: attachment; filename=' .$filename.".png");
        imagepng($image, null, 9, null);

        @imagedestroy($image);
        if($uStyle == 'ching') imagedestroy($ching);
        elseif($uStyle == 'fly') imagedestroy($fly);
        elseif($uStyle == 'wood') imagedestroy($wood);
        break;
    }
  }
  function getHeight($text,$flag)
  {
    $j=0;//for data array
    $text=str_replace("\r","",$text);
    $new_text=explode("\n", $text);

    $data=array();
    for($i=0;$i<count($new_text);$i++)
    {
      $count=strlen($new_text[$i]);
      if($count>$flag)
      {
        $tempData=$this->utf8_str_split($new_text[$i]);
        $tempPlus=0;
        $tempSplit=array();
        for($k=0;$k<count($tempData);$k++)
        {
          $tempPlus=$tempPlus+strlen($tempData[$k]);
          if($tempPlus == $flag)
          {
            array_push($tempSplit,($k));
            $tempPlus=0;
          }
          elseif($tempPlus>$flag)
          {
            array_push($tempSplit,($k-1));
            $tempPlus=strlen($tempData[$k]);
          }
        }
        array_push($tempSplit,count($tempData));
        $start=0;
        $tempString=null;
        foreach ($tempSplit as $value) {
          for($m=$start;$m<=$value;$m++)
          {
            @$tempString=$tempString.$tempData[$m];
          }
          if($tempString !== '') $data[$j++]=$tempString;
          $start=$value+1;
          $tempString=null;
        }
      }else{
        $data[$j++]=$new_text[$i];
      }
    }
    return $data;
  }
  function getHeightVertical($text)
  {
    $j=0;//for data array
    $text=str_replace("\r","",$text);
    $new_text=explode("\n", $text);

    $data=array();
    for($i=0;$i<count($new_text);$i++)
    {
      $data[$j++]=$new_text[$i];
    }
    return $data;
  }
  function getWidht($text)
  {
    $max=0;//find max width
    for($i=0;$i<count($text);$i++)
    {
      $string=$text[$i];
      $a=mb_strlen($string,'utf-8');
      $b=strlen($string)-$a;
      preg_match_all('!\d+!', $string, $matches);
      $var=implode('',$matches[0]);
      $num=strlen($var);//get num char

      $chi=($b/2);//get chi char
      preg_match_all('/\b[A-Z][A-Za-z0-9]+\b/', $string, $matches2); //get uppercase eng char
      $var2=implode('',$matches2[0]);
      $eng_upper=strlen($var2);//get num char


      $eng_lower=$a-$chi-$num-$eng_upper; //get lowercase eng char
      $len=$chi*2.8+$eng_upper*1.65+$eng_lower*1.15+$num*1;//different width count

      //$len=mb_strlen($text[$i]);old method
      if($len>$max) $max=$len;
    }
    return $max;
  }
  function verticalText($text){
    $text=str_replace(' ','　',$text);
    $text=str_replace("\r","",$text);
    $lines=explode("\n", $text);
    $linesCount=count($lines);
    $lineLength=0;
    $tempLineLength=0;

    for($i=0; $i<$linesCount; $i++) {
      $tempLineLength=mb_strlen($lines[$i], "UTF-8");
      if($tempLineLength>$lineLength) $lineLength=$tempLineLength;
      $lines[$i]=$this->utf8_str_split($lines[$i]);
      $lines[$i]=array_filter($lines[$i]);
    }
    $newString=null;
    for($j=0; $j<$lineLength; $j++){
      for($k=$linesCount-1; $k>=0; $k--) {
        if(isset($lines[$k][$j])) $x=$lines[$k][$j];
        else $x='　';
        $newString=$newString.$x;
      }
      $newString=$newString.'
';
    }
    return $newString;
  }
  function utf8_str_split($str, $split_len = 1){
      if (!preg_match('/^[0-9]+$/', $split_len) || $split_len < 1)
          return FALSE;

      $len = mb_strlen($str, 'UTF-8');
      if ($len <= $split_len)
          return array($str);

      preg_match_all('/.{'.$split_len.'}|[^\x00]{1,'.$split_len.'}$/us', $str, $ar);

      return $ar[0];
  }
  function filenameEscap($filename){
    $filename=str_replace('.','',$filename);
    $filename=str_replace(',','',$filename);
    return $filename;
  }
}

?>
