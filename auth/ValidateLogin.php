<?php
require_once('../connection/conf.php');

if(isset($_POST['submit'])){
    $email = stripslashes(htmlspecialchars(htmlentities($_POST['user'])));
    $password = stripslashes(htmlspecialchars(htmlentities($_POST['password'])));
    
    $stmt = mysqli_stmt_init($confg);
    $sqlUser = "SELECT * FROM user WHERE email = ? or NIS = ?";
    $sqlTeacher = "SELECT * FROM tbl_guru WHERE email = ? or nuptk_guru = ?";
    $sqlAdmin = "SELECT * FROM admin WHERE email = ? or nama = ?";
    if(mysqli_stmt_prepare($stmt,$sqlTeacher)){
        mysqli_stmt_bind_param($stmt,"ss",$email,$password);
        mysqli_stmt_execute($stmt);
        $res2 = mysqli_stmt_get_result($stmt);
        if($data2 = mysqli_fetch_assoc($res2)){
            $checkpwd2 = password_verify($password,$data2['password']);
            if($checkpwd2 == false){
                header('Location: login?act=passnotvalid');
            }else if($checkpwd2 == true){
                $_SESSION['id_Teacher'] = $data2['id_guru'];
                $_SESSION['Teacher'] = $data2['nama_guru'];
                $_SESSION['Teacher_nuptk'] = $data2['nuptk_guru'];
                $_SESSION['Teacher_email'] = $data2['email'];
                header('Location: login?act=Teacher');
            }else{
                header('Location: login?act=passnotvalid');
            }
        }else{
            echo"<script>window.location.href = 'login?act=notfound'</script>";
        }

    }else{
        header('Location: login?act=notvalid');
    }
    if(mysqli_stmt_prepare($stmt,$sqlAdmin)){
        mysqli_stmt_bind_param($stmt,"ss",$email,$password);
        mysqli_stmt_execute($stmt);
        $res3 = mysqli_stmt_get_result($stmt);
        if($data3 = mysqli_fetch_assoc($res3)){
            $checkpwd3 = password_verify($password,$data3['password']);
            if($checkpwd3 == false){
                header('Location: login?act=passnotvalid');
            }else if($checkpwd3 == true){
                $_SESSION['id_admin'] = $data3['id'];
                $_SESSION['admin'] = $data3['nama'];
                $_SESSION['email'] = $data3['email'];
                header('Location: login?act=Teacher');
            }else{
                header('Location: login?act=passnotvalid');
            }
        }else{
            echo"<script>window.location.href = 'login?act=notfound'</script>";
        }

    }else{
        header('Location: login?act=notvalid');
    }
    if(mysqli_stmt_prepare($stmt,$sqlUser)){
        mysqli_stmt_bind_param($stmt,"ss",$email,$password);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if($data = mysqli_fetch_assoc($res)){
            $checkpwd = password_verify($password,$data['password']);
                if($checkpwd){
                    $_SESSION['user'] = $data['name'];
                    $_SESSION['userId'] = $data['id'];
                    $_SESSION['kelas'] = $data['KELAS'];
                    $_SESSION['nis'] = $data['NIS'];
                    $_SESSION['email'] = $data['email'];
                    $_SESSION['no_hp'] = $data['no_hp'];
                    $_SESSION['wali_kelas'] = $data['wali_kelas'];
                    $_SESSION['alamat'] = $data['alamat'];
                    $_SESSION['waktu'] = $data['waktu'];
                    $_SESSION['agama'] = $data['agama'];
                    $_SESSION['poin'] = $data['poin'];
                    echo"<script>alert('success Login')</script>";
                    header('location: login?act=success');
                }else{
                        header('Location: login?act=passnotvalid');
                }
        }
    }
}

?>