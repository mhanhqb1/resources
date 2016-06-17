<?php

/**
 * 
 * Some common helper
 * @package View.Helper
 * @created 2014-11-30
 * @version 1.0
 * @author thailvn
 * @copyright Oceanize INC
 */
class CommonHelper extends AppHelper {

    /** @var array $helpers Use helpers */
    public $helpers = array('Text', 'Form');

    /**
     * Truncate string
     *    
     * @author thailvn
     * @param string $text Input string
     * @param int $length Length
     * @param object $options See more String::truncate    
     * @return string  
     */
    function truncate($text, $length = 100, $options = array()) {
        return $this->getCommonComponent()->truncate($text, $length, $options);
    }

     /**
     * Date format for application
     *    
     * @author thailvn
     * @param int $time Input DateTime        
     * @return string Date
     */
    function dateFormat($time) {
        return $this->getCommonComponent()->dateFormat($time);
    }

     /**
     * Get thumb image url
     *     
     * @author thailvn
     * @param string $fileName File name
     * @param string $size Thumb size     
     * @return string Thumb image url  
     */
    function thumb($fileName, $size = null, $type = null) {
        return $this->getCommonComponent()->thumb($fileName, $size, $type);
    }

    /**
     * Render CKEditor script
     *     
     * @author thailvn
     * @param array $params Options         
     * @return string Html 
     */
    function editor($params = array()) {
        include_once WWW_ROOT . 'ckeditor/ckeditor_custom.php';
        include_once WWW_ROOT . 'ckfinder/ckfinder.php';    
        $id = isset($params['id']) ? $params['id'] : '';
        $value = isset($params['value']) ? $params['value'] : '';
        $name  		= isset($params['name'])  	? $params['name']  	: '';
        $value 		= isset($params['value']) 	? $params['value'] 	: '';		
        $width 		= isset($params['width']) 	? $params['width'] 	: 0;		
        $height		= isset($params['height']) 	? $params['height'] : 0;		
        $CKEditor 	= new CKEditor();	
        $CKFinder   = new CKFinder();
        $config 	= array();
        $config['toolbar'] = array(
            array( 'Source'),
            array( 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'),	  
            array( 'Image', 'Smiley', 'Table', 'Link', 'Unlink'),	  
            array( 'Font','FontSize', 'Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript', '-', 'JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock', '-', 'TextColor', 'BGColor')
        );
        $config['height'] = $height;
        $config['width']  = $width;	
        //$config['filebrowserImageUploadUrl'] = Router::url('/') . "ckupload.php";	
        //$config['filebrowserImageBrowseUrl'] = Router::url('/') . "ckbrowser.php";	
        $events['instanceReady'] = 'function (ev) {
            alert("Loaded: " + ev.editor.name);
        }';
        $CKEditor->basePath = Router::url('/') . 'ckeditor/';
        
        /*
        $CKFinder->BasePath = Router::url('/') . 'ckfinder/';
        $CKFinder->BaseUrl = Configure::read('Config.EditorImageUrl');       
        $EditorUploadPath = Configure::read('Config.EditorUploadPath');
        if (empty($EditorUploadPath)) {
             $EditorUploadPath = WWW_ROOT . 'ckfinder' . DS . 'userfiles/'; 
        }
        $CKFinder->BaseDir = $EditorUploadPath; 
        * 
        */
        $CKFinder->SetupCKEditorObject($CKEditor);
        
        $config['filebrowserBrowseUrl'] = Router::url('/') . 'ckfinder/ckfinder.html';
        $config['filebrowserImageBrowseUrl'] = Router::url('/') . 'ckfinder/ckfinder.html?type=Images';
        $config['filebrowserFlashBrowseUrl'] = Router::url('/') . 'ckfinder/ckfinder.html?type=Flash';
        $config['filebrowserUploadUrl'] = Router::url('/') . 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
        $config['filebrowserImageUploadUrl'] = Router::url('/') . 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
        $config['filebrowserFlashUploadUrl'] = Router::url('/') . 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
        $params['type'] = 'textarea';
        $out = $CKEditor->editor($this->Form->input($id, $params), $id, $value, $config, null);
        return $out;
    }

    /**
     * Add image domain url for image url that is not image url
     *     
     * @author thailvn
     * @param string $imageUrl Image URL         
     * @return string Image URL 
     */
    public function paserImageUrl($imageUrl) {
        preg_match('/' . str_replace('/', '\/', Configure::read('Config.img_url')) . "/i", $imageUrl, $matches);
        if (empty($matches)) {
            return $imageUrl = Configure::read('Config.img_url') . $imageUrl;
        }
        return $imageUrl;
    }

    /**
     * Get url of static html page
     * @param string $kindStr
     * @return string
     */
    function getWebLink($kindStr = '') {
        // Init
        $apiUrlStr = Configure::read('API.Host');
        
        // Prepare language
        $pre = 'jp';
        $language = Configure::read('Config.language');
        if ($language == 'eng') {
            $pre = 'en';
        } else if ($language == 'vie') {
            $pre = 'vn';
        } else if ($language == 'tha') {
            $pre = 'th';
        } else if ($language == 'spa') {
            $pre = 'es';
        }
        
        // Build html link
        if ($kindStr == "userpolicy" || $kindStr == "policy" || $kindStr == "guideline") {
            $webLinkStr = $apiUrlStr . $pre . "/" . $kindStr . ".html?" . time();
        } else {
            $webLinkStr = $apiUrlStr . $pre . "/" . $kindStr . "_ios.html?" . time();
        }
        
        // Return
        return $webLinkStr;
    }
    
    /**
     * Get language for Landing page
     * @param string $msg
     * @param string $lang
     * @param array $args
     * @return string
     */
    function getlanguageLp($msg, $lang = '', $args = null) {
        $arrLangs = array('jpn', 'eng', 'tha', 'vie', 'spa');
        if (empty($lang) || !in_array($lang, $arrLangs)) {
            $lang = 'jpn';
        }
        
        if (!$msg) {
            return null;
        }
        
        App::uses('I18n', 'I18n');
        $translated = I18n::translate($msg, null, 'landing', 6 /*LC_MESSAGES*/, null, $lang);
        $arguments = func_get_args();
        return I18n::insertArgs($translated, array_slice($arguments, 2));
    }
    
}
