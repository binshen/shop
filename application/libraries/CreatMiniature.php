<?php
/***************************************
*類名：CreatMiniature
*功能：生成多種類型的縮略圖
*基本參數：$srcFile,$echoType
*方法用到的參數：
                $toFile,生成的文件
                $toW,生成的寬
                $toH,生成的高
                $bk1,背景顔色參數 以255爲最高
                $bk2,背景顔色參數
                $bk3,背景顔色參數

*例子：

    include("thumb.php");
    $cm=new CreatMiniature();
    $cm->SetVar("1.jpg","file");
    $cm->Distortion("dis_bei.jpg",150,200);
    $cm->Prorate("pro_bei.jpg",150,200);
    $cm->Cut("cut_bei.jpg",150,200);
    $cm->BackFill("fill_bei.jpg",150,200);

***************************************/

class CreatMiniature
{
    //公共變量
    var $srcFile="";        //原圖
    var $echoType;            //輸出圖片類型，link–不保存爲文件；file–保存爲文件
    var $im="";                //臨時變量
    var $srcW="";            //原圖寬
    var $srcH="";            //原圖高

    //設置變量及初始化
    function SetVar($srcFile,$echoType)
    {
        $this->srcFile=$srcFile;
        $this->echoType=$echoType;

        $info = "";
        $data = GetImageSize($this->srcFile,$info);
        switch ($data[2])
        {
         case 1:
           if(!function_exists("imagecreatefromgif")){
           /* echo "妳的GD庫不能使用GIF格式的圖片，請使用Jpeg或PNG格式！<a href=’javascript:go(-1);’>返回</a>";*/
            exit();
           }
           $this->im = ImageCreateFromGIF($this->srcFile);
           break;
        case 2:
          if(!function_exists("imagecreatefromjpeg")){
         /*  echo "妳的GD庫不能使用jpeg格式的圖片，請使用其它格式的圖片！<a href=’javascript:go(-1);’>返回</a>";*/
           exit();
          }
          $this->im = ImageCreateFromJpeg($this->srcFile);
          break;
        case 3:
          $this->im = ImageCreateFromPNG($this->srcFile);
          break;
      }
      $this->srcW=ImageSX($this->im);
      $this->srcH=ImageSY($this->im);
    }

    //生成扭曲型縮圖
    function Distortion($toFile,$toW,$toH)
    {
        $cImg=$this->CreatImage($this->im,$toW,$toH,0,0,0,0,$this->srcW,$this->srcH);
        return $this->EchoImage($cImg,$toFile);
        ImageDestroy($cImg);
    }

    //生成按比例縮放的縮圖
    function Prorate($toFile,$toW,$toH)
    {
        $toWH=$toW/$toH;
        $srcWH=$this->srcW/$this->srcH;
        if($toWH  <=  $srcWH)
        {
            $ftoW=$toW;
            $ftoH=$ftoW*($this->srcH/$this->srcW);
        }
        else
        {
              $ftoH=$toH;
              $ftoW=$ftoH*($this->srcW/$this->srcH);
        }
        if($this->srcW>$toW||$this->srcH>$toH)
        {
            $cImg=$this->CreatImage($this->im,$ftoW,$ftoH,0,0,0,0,$this->srcW,$this->srcH);
            return $this->EchoImage($cImg,$toFile);
            ImageDestroy($cImg);
        }
        else
        {
            $cImg=$this->CreatImage($this->im,$this->srcW,$this->srcH,0,0,0,0,$this->srcW,$this->srcH);
            return $this->EchoImage($cImg,$toFile);
            ImageDestroy($cImg);
        }
    }

    //生成最小裁剪後的縮圖
    function Cut($toFile,$toW,$toH)
    {
          $toWH=$toW/$toH;
          $srcWH=$this->srcW/$this->srcH;
          if($toWH <= $srcWH)
          {
               $ctoH=$toH;
               $ctoW=$ctoH*($this->srcW/$this->srcH);
          }
          else
          {
              $ctoW=$toW;
              $ctoH=$ctoW*($this->srcH/$this->srcW);
          }
        $allImg=$this->CreatImage($this->im,$ctoW,$ctoH,0,0,0,0,$this->srcW,$this->srcH);
        $cImg=$this->CreatImage($allImg,$toW,$toH,0,0,($ctoW-$toW)/2,($ctoH-$toH)/2,$toW,$toH);
        return $this->EchoImage($cImg,$toFile);
        ImageDestroy($cImg);
        ImageDestroy($allImg);
    }


	function BackFill1($toFile,$toW,$toH,$bk1=255,$bk2=255,$bk3=255)
    {
    	if($this->srcW > $toW)
    	{
    		$scaleW= $toW / $this->srcW;
    		$tooH=$this->srcH*$scaleW;
    		$this->BackFill($toFile,$toW,$tooH,$bk1=255,$bk2=255,$bk3=255);

    	}
    	else
    	{
    		$this->BackFill($toFile,$this->srcW,$this->srcH,$bk1=255,$bk2=255,$bk3=255);
    	}

    }

    //生成背景填充的縮圖
    function BackFill($toFile,$toW,$toH,$bk1=255,$bk2=255,$bk3=255)
    {
        $toWH=$toW/$toH;
        $srcWH=$this->srcW/$this->srcH;
        if($toWH <= $srcWH)
        {
            $ftoW=$toW;
            $ftoH=$ftoW*($this->srcH/$this->srcW);
        }
        else
        {
              $ftoH=$toH;
              $ftoW=$ftoH*($this->srcW/$this->srcH);
        }
        if(function_exists("imagecreatetruecolor"))
        {
            @$cImg=ImageCreateTrueColor($toW,$toH);
            if(!$cImg)
            {
                $cImg=ImageCreate($toW,$toH);
            }
        }
        else
        {
            $cImg=ImageCreate($toW,$toH);
        }
        $backcolor = imagecolorallocate($cImg, $bk1, $bk2, $bk3);        //填充的背景顔色
        ImageFilledRectangle($cImg,0,0,$toW,$toH,$backcolor);
        if($this->srcW>$toW||$this->srcH>$toH)
        {
            $proImg=$this->CreatImage($this->im,$ftoW,$ftoH,0,0,0,0,$this->srcW,$this->srcH);
            
             //if($ftoW< $toW)
             //{
             //    ImageCopyMerge($cImg,$proImg,($toW-$ftoW)/2,0,0,0,$ftoW,$ftoH,100);
             //}
             //else if($ftoH<$toH)
             //{
             //    ImageCopyMerge($cImg,$proImg,0,($toH-$ftoH)/2,0,0,$ftoW,$ftoH,100);
             //}
             
            if($ftoW <$toW && $ftoH<$toH)
            {
             	ImageCopy($cImg,$proImg,($toW-$ftoW)/2,($toH-$ftoH)/2,0,0,$ftoW,$ftoH);
            }
            else
            {
            	if($ftoW<$toW)
            	{
                	 ImageCopy($cImg,$proImg,($toW-$ftoW)/2,0,0,0,$ftoW,$ftoH);
            	}
            	else if($ftoH<$toH)
            	{
                 	ImageCopy($cImg,$proImg,0,($toH-$ftoH)/2,0,0,$ftoW,$ftoH);
            	}
            	else
            	{
                 	ImageCopy($cImg,$proImg,0,0,0,0,$ftoW,$ftoH);
            	}
            }
        }
        else
        {
             ImageCopyMerge($cImg,$this->im,($toW-$this->srcW)/2,($toH-$this->srcH)/2,0,0,$this->srcW,$this->srcH,100);
        }
        return $this->EchoImage($cImg,$toFile);
        ImageDestroy($cImg);
    }
	
	function BackFill_auto($toFile,$toW,$toH,$bk1=255,$bk2=255,$bk3=255)
    {
		if($this->srcW<$this->srcH)
		{
			if($this->srcH>$toH)
			{
				$toBili=$toH/$this->srcH;
				$toFW=$toBili*$this->srcW;
				$toFH=$toH;
			}
			else
			{
				if($this->srcW>$toW)
				{
					$toBili=$toW/$this->srcW;
					$toFW=$toW;
					$toFH=$toBili*$this->srcH;
				}
				else
				{
					$toFH=$this->srcH;
					$toFW=$this->srcW;
				}
			}
		}
		else
		{
			if($this->srcW>$toW)
			{
				$toBili=$toW/$this->srcW;
				$toFH=$toBili*$this->srcH;
				$toFW=$toW;
			}
			else
			{
				if($this->srcH>$toH)
				{
					$toBili=$toH/$this->srcH;
					$toFH=$toH;
					$toFW=$toBili*$this->srcW;
				}
				else
				{
					$toFH=$this->srcH;
					$toFW=$this->srcW;
				}
			}
			
		}
        /*$toWH=$toW/$toH;
        $srcWH=$this->srcW/$this->srcH;
        if($toWH <= $srcWH)
        {
            $ftoW=$toW;
            $ftoH=$ftoW*($this->srcH/$this->srcW);
        }
        else
        {
              $ftoH=$toH;
              $ftoW=$ftoH*($this->srcW/$this->srcH);
        }*/
        if(function_exists("imagecreatetruecolor"))
        {
            @$cImg=ImageCreateTrueColor($toFW,$toFH);
            if(!$cImg)
            {
                $cImg=ImageCreate($toFW,$toFH);
            }
        }
        else
        {
            $cImg=ImageCreate($toFW,$toFH);
        }
        $backcolor = imagecolorallocate($cImg, $bk1, $bk2, $bk3);        //填充的背景顔色
        ImageFilledRectangle($cImg,0,0,$toFW,$toFH,$backcolor);
        if($this->srcW>$toFW||$this->srcH>$toFH)
        {
            $proImg=$this->CreatImage($this->im,$toFW,$toFH,0,0,0,0,$this->srcW,$this->srcH);
			ImageCopyMerge($cImg,$proImg,0,0,0,0,$toFW,$toFH,100);
            /*
             if($ftoW< $toW)
             {
                 ImageCopyMerge($cImg,$proImg,($toW-$ftoW)/2,0,0,0,$ftoW,$ftoH,100);
             }
             else if($ftoH<$toH)
             {
                 ImageCopyMerge($cImg,$proImg,0,($toH-$ftoH)/2,0,0,$ftoW,$ftoH,100);
             }
             */
           /* if($ftoW <$toW && $ftoH<$toH)
            {
             	ImageCopy($cImg,$proImg,($toW-$ftoW)/2,($toH-$ftoH)/2,0,0,$ftoW,$ftoH);
            }
            else
            {
            	if($ftoW<$toW)
            	{
                	 ImageCopy($cImg,$proImg,($toW-$ftoW)/2,0,0,0,$ftoW,$ftoH);
            	}
            	else if($ftoH<$toH)
            	{
                 	ImageCopy($cImg,$proImg,0,($toH-$ftoH)/2,0,0,$ftoW,$ftoH);
            	}
            	else
            	{
                 	ImageCopy($cImg,$proImg,0,0,0,0,$ftoW,$ftoH);
            	}
            }*/
        }
        else
        {
             ImageCopyMerge($cImg,$this->im,($toFW-$this->srcW)/2,($toFH-$this->srcH)/2,0,0,$this->srcW,$this->srcH,100);
        }
        return $this->EchoImage($cImg,$toFile);
        ImageDestroy($cImg);
    }



    function CreatImage($img,$creatW,$creatH,$dstX,$dstY,$srcX,$srcY,$srcImgW,$srcImgH)
    {
        if(function_exists("imagecreatetruecolor"))
        {
            @$creatImg = ImageCreateTrueColor($creatW,$creatH);
            if($creatImg)
                ImageCopyResampled($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
            else
            {
                $creatImg=ImageCreate($creatW,$creatH);
                //ImageCopyResized($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
				ImageCopyResampled($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
            }
         }
         else
         {
            $creatImg=ImageCreate($creatW,$creatH);
            //ImageCopyResized($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
			ImageCopyResampled($creatImg,$img,$dstX,$dstY,$srcX,$srcY,$creatW,$creatH,$srcImgW,$srcImgH);
         }
         return $creatImg;
    }

    //輸出圖片，link—只輸出，不保存文件。file–保存爲文件
    function EchoImage($img,$to_File)
    {
        switch($this->echoType)
        {
            case "link":
                if(function_exists('imagejpeg')) return ImageJpeg($img);
                else return ImagePNG($img);
                break;
            case "file":
                if(function_exists('imagejpeg'))return ImageJpeg($img,$to_File,100);
				else return ImagePNG($img,$to_File);
                break;
        }
    }

}
?>

