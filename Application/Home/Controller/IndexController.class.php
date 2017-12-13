<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index(){

        $this -> display();
    }

    /**
     * geetest生成验证码
     */
    public function StartCaptchaServlet(){
        $geetest_id=C('GEETEST_ID');
        $geetest_key=C('GEETEST_KEY');
        $geetest=new \Org\Xb\Geetest($geetest_id,$geetest_key);

        // 这个是用户的标识，或者说是给极验服务器区分的标识，如果你项目没有预先设置，可以像下面这样设置：
        if(!isset($_SESSION['user_id'])){
            $_SESSION['user_id']=uniqid();// 生成一个唯一ID,也可随意设置
        }
        $user_id = $_SESSION['user_id'];
        $data = array(
            "user_id" => $user_id, # 网站用户id
            "client_type" => "web", #web:电脑上的浏览器；h5:手机上的浏览器，包括移动应用内完全内置的web_view；native：通过原生SDK植入APP应用的方式
            "ip_address" => "127.0.0.1" # 请在此处传输用户请求验证时所携带的IP
        );
        $status = $geetest->pre_process($data, 1);
        $_SESSION['gtserver'] = $status;
        $_SESSION['user_id'] = $data['user_id'];
        echo $geetest->get_response_str();
    }

    /**
     * geetest submit 提交验证
     */
    public function VerifyLoginServlet(){
        $data=I('post.');
        if($data['username'] != 'admin'){
            echo '用户名错误';die;
        }
        if($data['password'] != 'admin'){
            echo  '密码错误';die;
        }
        if (geetest_chcek_verify($data)) {
            echo '验证成功';
        }else{
            echo '验证失败';
        }
    }
}