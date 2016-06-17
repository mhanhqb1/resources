<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  Controller
 * @extends  Controller
 */


use Fuel\Core\Controller;
use Fuel\Core\Response;
use Fuel\Core\View;
use Fuel\Core\ViewModel;
use Facebook\FacebookSession;
use Facebook\FacebookSDKException;

class Controller_Welcome extends \Controller
{

	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_index()
	{
        /*
        include(APPPATH . '/classes/lib/simple_html_dom.php');
        $url = "http://vnexpress.net/rss/oto-xe-may.rss";
        $str = file_get_contents($url);		
        $html = str_get_html($str); //var_dump($html); exit;
        $result = array();
        foreach ($html->find('item') as $article) {
            $result[] = array(
                'title' => html_by_tag($article->innertext, '<title>', '</title>'),
                'link' => html_by_tag($article->innertext, '<link>', '</link>'),
                'description' => html_by_tag($article->innertext, '<description>', '</description>'),
                'pubDate' => html_by_tag($article->innertext, '<pubDate>', '</pubDate>'),
            );
        }
        print_r($result); exit;    
        * 
        */
		return Response::forge(View::forge('welcome/index'));
	}

	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_hello()
	{
		return Response::forge(Presenter::forge('welcome/hello'));
	}

	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('welcome/404'), 404);
	}
}
