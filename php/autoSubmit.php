<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * 自动提交demo
 *
 * @author: Liangxifeng
 * @date: 2015-07-18
 */
class AutoSubmit extends CI_Controller 
{
	public function __construct()
	{
        parent::__construct();
		$this->load->library('session');
	}
    /*
     * 测试session信息
     */
    function index()
    {
        echo 'loading...';
        echo $this->create_html();
        //$this->load->view('testA.html');
    }
    function create_html()
    {
                    $html = <<<eot
                    <html>
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
                    </head>
                    <body style="display:none" onload="javascript:document.pay_form.submit();">
                        <form id="pay_form" name="pay_form" action="/index.php/tester/b/action" method="post">
eot;
                      $html .= <<<eot
                        <input type='text' name='uName' value='liangxifeng' />
                        <input type="submit" type="hidden">
                        </form>
                    </body>
                    </html>
eot;
            return $html;

    }
    function action()
    {
        var_dump($this->input->post());
    }
}
