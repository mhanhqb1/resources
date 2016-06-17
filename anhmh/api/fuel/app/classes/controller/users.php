<?php

/**
 * Controller for actions on User
 *
 * @package Controller
 * @created 2015-03-19
 * @version 1.0
 * @author Le Tuan Tu
 * @copyright Oceanize INC
 */
class Controller_Users extends \Controller_App
{
    /**
     * Add and update info for User
     *
     * @return boolean
     */
    public function action_addUpdate()
    {
        return \Bus\Users_AddUpdate::getInstance()->execute();
    }

    /**
     * Get list User (with array count)
     *
     * @return boolean
     */
    public function action_list()
    {
        return \Bus\Users_List::getInstance()->execute();
    }

    /**
     * Get list User (without array count)
     *
     * @return boolean
     */
    public function action_all()
    {
        return \Bus\Users_All::getInstance()->execute();
    }

    /**
     * Disable/Enable list User
     *
     * @return boolean
     */
    public function action_disable()
    {
        return \Bus\Users_Disable::getInstance()->execute();
    }

    /**
     * Get detail User
     *
     * @return boolean
     */
    public function action_detail()
    {
        return \Bus\Users_Detail::getInstance()->execute();
    }

    /**
     * Login User
     *
     * @return boolean
     */
    public function action_login()
    {
        return \Bus\Users_Login::getInstance()->execute();
    }

    /**
     * Register User
     *
     * @return boolean
     */
    public function action_register()
    {
        return \Bus\Users_Register::getInstance()->execute();
    }

    /**
     *  Login facebook for user
     *
     * @return boolean
     */
    public function action_fbLogin()
    {
        return \Bus\Users_FbLogin::getInstance()->execute();
    }

    /**
     *  Action forget password for user
     *
     * @return boolean
     */
    public function action_forgetPassword()
    {
        return \Bus\Users_Forgetpassword::getInstance()->execute();
    }

    /**
     * Resend email for user forget password
     *
     * @return boolean
     */
    public function action_resendForgetPassword()
    {
        return \Bus\Users_ResendForgetPassword::getInstance()->execute();
    }

    /**
     *  Update password field for UserProfile
     *
     * @return boolean
     */
    public function action_updatePassword()
    {
        return \Bus\Users_UpdatePassword::getInstance()->execute();
    }

    /**
     *  Active for user has register requested
     *
     * @return boolean
     */
    public function action_registerActive()
    {
        return \Bus\Users_RegisterActive::getInstance()->execute();
    }

    /**
     *  Update password field for UserProfile
     *
     * @return boolean
     */
    public function action_changePassword()
    {
        return \Bus\Users_ChangePassword::getInstance()->execute();
    }

    /**
     * Get profile of User
     *
     * @return boolean
     */
    public function action_profile()
    {
        return \Bus\Users_Profile::getInstance()->execute();
    }

    /**
     * Update info for User
     *
     * @return boolean
     */
    public function action_updateProfile()
    {
        return \Bus\Users_UpdateProfile::getInstance()->execute();
    }

    // /**
    //  * Check current user's password
    //  *
    //  * @return boolean
    //  */
    // public function action_checkPassword()
    // {
    //     return \Bus\Users_CheckPassword::getInstance()->execute();
    // }

    /**
     * Cancel user
     *
     * @return boolean
     */
    public function action_quit()
    {
        return \Bus\Users_Quit::getInstance()->execute();
    }

    /**
     *  Login facebook by token for user
     *
     * @return boolean
     */
    public function action_FbLoginToken()
    {
        return \Bus\Users_FbLoginToken::getInstance()->execute();
    }

    /**
     *  Login facebook by token for user
     *
     * @return boolean
     */
    public function action_twitterLoginToken()
    {
        return \Bus\Users_TwitterLoginToken::getInstance()->execute();
    }

    /**
     *  Search info user
     *
     * @return boolean
     */
    public function action_searchInfo()
    {
        return \Bus\Users_SearchInfo::getInstance()->execute();
    }

    /**
     *  Check email
     *
     * @return boolean
     */
    public function action_checkEmail()
    {
        return \Bus\Users_CheckEmail::getInstance()->execute();
    }

    /**
     * Get time line of User (with array count)
     *
     * @return boolean
     */
    public function action_timeline()
    {
        return \Bus\Users_Timeline::getInstance()->execute();
    }
    /**
     * Get recommend
     *
     * @return boolean
     */
    public function action_recommend()
    {
        return \Bus\Users_Recommend::getInstance()->execute();
    }
    
    /**
     * Register User
     *
     * @return boolean
     */
    public function action_registeremail()
    {
        return \Bus\Users_RegisterEmail::getInstance()->execute();
    }
    
    /**
     * Update info for User
     *
     * @return boolean
     */
    public function action_updateTeam()
    {
        return \Bus\Users_UpdateTeam::getInstance()->execute();
    }

    /**
     * Check login failed
     *
     * @return boolean
     */
    public function action_checkLoginFailed()
    {
        return \Bus\Users_CheckLoginFailed::getInstance()->execute();
    }
}
