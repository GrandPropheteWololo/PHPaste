<?php 
    require_once 'config.php';

    if(!empty($_POST['nickname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_retype']))
    {
        $nickname = htmlspecialchars($_POST['nickname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $password_retype = htmlspecialchars($_POST['password_retype']);

        $check = $bdd->prepare('SELECT nickname, email, password FROM userlogin WHERE email = ?');
        $check->execute(array($email));
        $data = $check->fetch();
        $row = $check->rowCount();

        if($row == 0){ 
            if(strlen($nickname) <= 100){
                if(strlen($email) <= 100){
                    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        if($password == $password_retype){

                            $cost = ['cost' => 12];
                            $password = password_hash($password, PASSWORD_BCRYPT, $cost);
                            
                            $ip = $_SERVER['REMOTE_ADDR'];

                            
                            $insert = $bdd->prepare('INSERT INTO userlogin(nickname, email, password, ip) VALUES(:nickname, :email, :password, :ip)');
                            $insert->execute(array(
                                'nickname' => $nickname,
                                'email' => $email,
                                'password' => $password,
                                'ip' => $ip
                            ));

                            header('Location:inscription.php?reg_err=success');
                            die();
                        }else{ header('Location: inscription.php?reg_err=password'); die();}
                    }else{ header('Location: inscription.php?reg_err=email'); die();}
                }else{ header('Location: inscription.php?reg_err=email_length'); die();}
            }else{ header('Location: inscription.php?reg_err=nickname_length'); die();}
        }else{ header('Location: inscription.php?reg_err=already'); die();}
    }