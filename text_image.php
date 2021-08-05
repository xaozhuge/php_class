<?php
	//根据文字生成图片
	function textImage(){
		//字体大小
		$size  = 80;
		//字体类型
		$font  = "font/PingFangMedium.ttf";
		//显示的文字
		$text  = "严禁复制";
		//创建空白图片
		$img   = imagecreate(600, 860);
		//给图片分配颜色
		imagecolorallocate($img, 0xff, 0xff, 0xff);
		//设置字体颜色
		$black = imagecolorallocate($img, 0xdf, 0xdf, 0xdf);
		//将ttf文字写到图片中
		imagettftext($img, $size, 45, 180, 580, $black, $font, $text);
		//发送头信息
		header('Content-Type: image/png');
		//图片名称，保存成文件或浏览器输出
		$file_name = '1.png';
		if($file_name){
			imagepng($img, $file_name);
		}else{
			imagepng($img);
		}
	}
