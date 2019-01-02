<?php

//Databas: emibe986
//Användaren "emibe986" utan lösenord får bara göra SELECT.
//Användaren "emibe986_edit" med lösenord "Goobergeeber" får göra SELECT, INSERT, UPDATE och DELETE.
//Användaren "emibe986_admin" med lösenord "Wooberweever" får göra allt: SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER samt 

// mysqli_connect(host,username,password,dbname,port,socket);

$db = mysqli_connect("mysql.itn.liu.se", "emibe986_edmin", "Wooberweever", "emibe986") or die("can't connect  to mysql!");

?>