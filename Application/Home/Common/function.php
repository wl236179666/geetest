<?php

/**
 * geetest检测验证码
 */

function geetest_chcek_verify($data){
    $geetest_id=C('GEETEST_ID');
    $geetest_key=C('GEETEST_KEY');
    $geetest=new\Org\Xb\Geetest($geetest_id,$geetest_key);

    $user_id = $_SESSION['user_id'];

    if ($_SESSION['gtserver'] == 1){
        echo '正常模式';
        //正常模式获取验证结果
        $result=$geetest->success_validate($data['geetest_challenge'],$data['geetest_validate'],$data['geetest_seccode'],$user_id);
        if ($result) {
            return true;
        } else{
            return false;
        }
    }else{
        //宕机模式获取验证结果
        echo '宕机模式';
        if ($geetest->fail_validate($data['geetest_challenge'],$data['geetest_validate'],$data['geetest_seccode'])){
            //可在这里进行其他验证
            return true;
        }else{
            return false;
        }
    }
}