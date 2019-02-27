<?php
    $file="pbook/".$_POST["filename"].".txt";
    if(file_exists($file))
    {
         echo "当前目录中，文件".$file."存在";
    }
    else
    {
         echo "当前目录中，文件".$file."不存在";
    }