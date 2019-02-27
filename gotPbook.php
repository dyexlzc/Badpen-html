<?php
    $file=$_POST["filename"].".txt";
    $fp = fopen("pbook/".$file,"r");
    $str = fread($fp,filesize("pbook/".$file));//指定读取大小，这里把整个文件内容读取出来
    echo($str);
    fclose($fp);
