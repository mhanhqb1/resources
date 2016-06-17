<?php

/* 
 * Description : Class contain methods used for Landing screen
 * User        : KienNH
 * Date created: 2015/11/10
 */

class LpController extends AppController {
    
    /**
     * Load library
     */
    function beforeFilter () {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    
    /**
     * Landing page with Japanese version
     */
    function index($language = '') {
        // Logged-in
        if (!empty($this->AppUI->id)) {
            return $this->redirect(BASE_URL . '/top');
        }
        
        $this->set('isMobile', $this->isMobile());
        
        // Select language
        $lang = $language;
        if (empty($lang)) {
            if ($this->Cookie->check(COOKIE_KEY_LANGUAGE)) {
                // Select from cookie
                $lang = $this->Cookie->read(COOKIE_KEY_LANGUAGE);
            } else if (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                // Select from browser language
                $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
            }
        }
        $lang = $this->validateLang($lang);// Check or get default language
        $this->set('lpLang', $lang);
        $lang = $this->validateLang($lang, 2);// language for html
        $this->set('lpLang2Digit', $lang);
        
        // Select layout
        $this->layout = 'lp';
        if ($this->isMobile()) {
            $this->render('sp');
        } else {
            $this->render('pc');
        }
    }
    
    /**
     * Landing page with English version
     */
    function en() {
        $this->index('eng');
    }
    
    /**
     * Landing page with Japanese version
     */
    function jp() {
        $this->index('jpn');
    }
    
    /**
     * Landing page with Spain version
     */
    function es() {
        $this->index('spa');
    }
    
    /**
     * Thank You page when contact success
     */
    function thanks() {
        // Get current language
        $lang = $this->Session->read('landing.language.submit');
        $lang = $this->validateLang($lang);
        $this->set('lpLang', $lang);
        $lang = $this->validateLang($lang, 2);// language for html
        $this->set('lpLang2Digit', $lang);
        
        $this->set('isMobile', $this->isMobile());
        
        $this->layout = 'lp';
        if ($this->isMobile()) {
            $this->render('thank_sp');
        } else {
            $this->render('thank_pc');
        }
    }
    
}
