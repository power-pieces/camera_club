<?php
//测试图片存储
$image = $_REQUEST["image"];
$image = base64_decode($image);
$savePath = "../images/test.jpg";
file_put_contents($savePath,$image);