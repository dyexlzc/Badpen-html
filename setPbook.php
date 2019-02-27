<?php
    echo "正在写入...";
    $file=$_POST["filename"].".txt";
    $content=$_POST["content"];
    $myfile = fopen("pbook/".$file, "w");
    fwrite($myfile, $content);
    fclose($myfile);
    echo "写入成功!";