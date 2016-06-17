<div id="section1">
    <div id="topMenu" class="noselect">
        <a class="topMenuItem topMenuItemFacebook" href="https://www.facebook.com/Bmaps-1143055982381030/?fref=ts" target="_blank">facebook</a>
        <a class="topMenuItem topMenuItem1" href="#contact"><?php echo $this->Common->getlanguageLp('LP_MENU_CONTACT', $lpLang) ?></a>
        <a class="topMenuItem topMenuItem2" href="#social"><?php echo $this->Common->getlanguageLp('LP_MENU_SOCIAL', $lpLang) ?></a>
        <a class="topMenuItem topMenuItem3" href="#about"><?php echo $this->Common->getlanguageLp('LP_MENU_WHAT', $lpLang) ?></a>
    </div>
    <div id="section1_1">
        <div id="section1_1_title">
            <?php echo $this->Common->getlanguageLp('LP_SECTION_1_1_TITLE', $lpLang) ?>
        </div>
        <img src="<?php echo BASE_URL ?>/img/landing/section1_1.png"/>
        <div id="section1_1_supporter">
            <?php echo $this->Common->getlanguageLp('LP_BECOME_SUPPORTER', $lpLang) ?>
        </div>
    </div>
    <a id="section1_contact" class="noselect" href="#contact">
        <?php echo $this->Common->getlanguageLp('LP_BTN_GO_CONTACT', $lpLang) ?>
    </a>
    <div id="section1_2">
        <?php echo $this->Common->getlanguageLp('LP_MSG_TRIAL_VERSION', $lpLang) ?>
    </div>
</div>

<!--div id="section2">
    <div class="section2_item">
        <img src="<?php echo BASE_URL ?>/img/landing/section2_1.png"/>
    </div>
    <div class="section2_item">
        <img src="<?php echo BASE_URL ?>/img/landing/section2_2.png"/>
    </div>
    <div class="section2_item">
        <img src="<?php echo BASE_URL ?>/img/landing/section2_3.png"/>
    </div>
    <div class="section2_item">
        <img src="<?php echo BASE_URL ?>/img/landing/section2_4.png"/>
    </div>
</div-->

<div id="about">
    <div id="about_title">
        <img src="<?php echo BASE_URL ?>/img/landing/section3_title.png"/>
        <span><?php echo $this->Common->getlanguageLp('LP_MENU_WHAT', $lpLang) ?></span>
    </div>
    <div id="about_content">
        <div id="about_1"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_1', $lpLang) ?></div>
        <div id="about_2"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_2', $lpLang) ?></div>
        <div id="about_3"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_3', $lpLang) ?></div>
        <div id="about_4">
            <img src="<?php echo BASE_URL ?>/img/landing/section3_4.png"/>
        </div>
        <div id="about_5"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_5', $lpLang) ?></div>
        <div id="about_6" class="about_item">
            <div class="about_item_img">
                <?php if(!empty($lpLang2Digit) && $lpLang2Digit == 'en'): ?>
                <img src="<?php echo BASE_URL ?>/img/landing/section3_item_1_en.png"/>
                <?php elseif(!empty($lpLang2Digit) && $lpLang2Digit == 'es'): ?>
                <img src="<?php echo BASE_URL ?>/img/landing/section3_item_1_es.png"/>
                <?php else: ?>
                <img src="<?php echo BASE_URL ?>/img/landing/section3_item_1.png"/>
                <?php endif; ?>
            </div>
            <div class="about_item_txt">
                <div class="about_item_txt_1"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_6_ITEM_TXT_1', $lpLang) ?></div>
                <div class="about_item_txt_2"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_6_ITEM_TXT_2', $lpLang) ?></div>
                <div class="about_item_txt_3"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_6_ITEM_TXT_3', $lpLang) ?></div>
            </div>
        </div>
        <div id="about_7" class="about_item about_item_bot">
            <div class="about_item_txt">
                <div class="about_item_txt_1"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_7_ITEM_TXT_1', $lpLang) ?></div>
                <div class="about_item_txt_2"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_7_ITEM_TXT_2', $lpLang) ?></div>
                <div class="about_item_txt_3"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_7_ITEM_TXT_3', $lpLang) ?></div>
            </div>
            <div class="about_item_img">
                <?php if(!empty($lpLang2Digit) && $lpLang2Digit == 'en'): ?>
                <img src="<?php echo BASE_URL ?>/img/landing/section3_item_2_en.png"/>
                <?php elseif(!empty($lpLang2Digit) && $lpLang2Digit == 'es'): ?>
                <img src="<?php echo BASE_URL ?>/img/landing/section3_item_2_es.png"/>
                <?php else: ?>
                <img src="<?php echo BASE_URL ?>/img/landing/section3_item_2.png"/>
                <?php endif; ?>
            </div>
        </div>
        <div id="about_8" class="about_item">
            <div class="about_item_img">
                <img src="<?php echo BASE_URL ?>/img/landing/section3_item_3.png"/>
            </div>
            <div class="about_item_txt">
                <div class="about_item_txt_1"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_8_ITEM_TXT_1', $lpLang) ?></div>
                <div class="about_item_txt_2"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_8_ITEM_TXT_2', $lpLang) ?></div>
                <div class="about_item_txt_3"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_8_ITEM_TXT_3', $lpLang) ?></div>
            </div>
        </div>
        <div id="about_9" class="about_item about_item_bot">
            <div class="about_item_txt">
                <div class="about_item_txt_1"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_9_ITEM_TXT_1', $lpLang) ?></div>
                <div class="about_item_txt_2"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_9_ITEM_TXT_2', $lpLang) ?></div>
                <div class="about_item_txt_3"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_3_9_ITEM_TXT_3', $lpLang) ?></div>
            </div>
            <div class="about_item_img">
                <img src="<?php echo BASE_URL ?>/img/landing/section3_item_4.png"/>
            </div>
        </div>
    </div>
</div>

<div id="section4"></div>

<div id="section5">
    <div id="section5_container">
        <div id="section5_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_5_TITLE', $lpLang) ?></div>
        <div id="section5_1" class="section5_item">
            <div class="section5_item_img">
                <img src="<?php echo BASE_URL ?>/img/landing/section5_item_1.png"/>
            </div>
            <div class="section5_item_txt">
                <div class="section5_item_txt_step"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_5_ITEM_TXT_STEP_1', $lpLang) ?></div>
                <div class="section5_item_txt_detail"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_5_ITEM_TXT_DETAIL_1', $lpLang) ?></div>
                <div class="section5_item_next">
                    <img src="<?php echo BASE_URL ?>/img/landing/next_down.png"/>
                </div>
            </div>
        </div>
        <div id="section5_2" class="section5_item">
            <div class="section5_item_img">
                <?php if(!empty($lpLang2Digit) && $lpLang2Digit == 'en'): ?>
                <img src="<?php echo BASE_URL ?>/img/landing/section5_item_2_en.png"/>
                <?php elseif(!empty($lpLang2Digit) && $lpLang2Digit == 'es'): ?>
                <img src="<?php echo BASE_URL ?>/img/landing/section5_item_2_es.png"/>
                <?php else: ?>
                <img src="<?php echo BASE_URL ?>/img/landing/section5_item_2.png"/>
                <?php endif; ?>
            </div>
            <div class="section5_item_txt">
                <div class="section5_item_txt_step"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_5_ITEM_TXT_STEP_2', $lpLang) ?></div>
                <div class="section5_item_txt_detail"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_5_ITEM_TXT_DETAIL_2', $lpLang) ?></div>
                <div class="section5_item_next">
                    <img src="<?php echo BASE_URL ?>/img/landing/next_down.png"/>
                </div>
            </div>
        </div>
        <div id="section5_3" class="section5_item">
            <div class="section5_item_img">
                <img src="<?php echo BASE_URL ?>/img/landing/section5_item_3.png"/>
            </div>
            <div class="section5_item_txt">
                <div class="section5_item_txt_step"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_5_ITEM_TXT_STEP_3', $lpLang) ?></div>
                <div class="section5_item_txt_detail"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_5_ITEM_TXT_DETAIL_3', $lpLang) ?></div>
                <div class="section5_item_next">
                    <img src="<?php echo BASE_URL ?>/img/landing/next_down.png"/>
                </div>
            </div>
        </div>
        <div id="section5_4" class="section5_item">
            <div class="section5_item_img">
                <img src="<?php echo BASE_URL ?>/img/landing/section5_item_4.png"/>
            </div>
            <div class="section5_item_txt">
                <div class="section5_item_txt_step"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_5_ITEM_TXT_STEP_4', $lpLang) ?></div>
                <div class="section5_item_txt_detail"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_5_ITEM_TXT_DETAIL_4', $lpLang) ?></div>
            </div>
        </div>
    </div>
</div>
<div id="section5_bot">
    <?php if(!empty($lpLang2Digit) && $lpLang2Digit == 'en'): ?>
    <img src="<?php echo BASE_URL ?>/img/landing/section5_bot_en.png"/>
    <?php elseif(!empty($lpLang2Digit) && $lpLang2Digit == 'es'): ?>
    <img src="<?php echo BASE_URL ?>/img/landing/section5_bot_es.png"/>
    <?php else: ?>
    <img src="<?php echo BASE_URL ?>/img/landing/section5_bot.png"/>
    <?php endif; ?>
</div>

<div id="section6">
    <div id="section6_container">
        <div id="section6_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_TITLE', $lpLang) ?></div>
        <div id="section6_1">
            <div id="section6_1_left">
                <div class="section6_1_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_1_TITLE_LEFT', $lpLang) ?></div>
                <div class="section6_1_text">
                    <?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_1_TEXT_LEFT', $lpLang) ?>
                    <div id="section6_rank">
                        <?php if(!empty($lpLang2Digit) && $lpLang2Digit == 'en'): ?>
                        <img src="<?php echo BASE_URL ?>/img/landing/section6_rank_en.png"/>
                        <?php elseif(!empty($lpLang2Digit) && $lpLang2Digit == 'es'): ?>
                        <img src="<?php echo BASE_URL ?>/img/landing/section6_rank_es.png"/>
                        <?php else: ?>
                        <img src="<?php echo BASE_URL ?>/img/landing/section6_rank.png"/>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div id="section6_1_right">
                <div class="section6_1_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_1_TITLE_RIGHT', $lpLang) ?></div>
                <div class="section6_1_text">
                    <?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_1_TEXT_RIGHT', $lpLang) ?>
                </div>
            </div>
        </div>

        <div id="section6_2" class="section6_item section6_item_1">
            <div class="section6_item_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_TITLE_1', $lpLang) ?></div>
            <div class="section6_item_table">
                <div class="section6_item_row section6_item_row_1">
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_1.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_1_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_1_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_2.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_2_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_2_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                </div>
                <div class="section6_item_row section6_item_row_2">
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_3.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_3_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_3_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_4.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_4_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_4_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="section6_3" class="section6_item section6_item_2">
            <div class="section6_item_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_TITLE_2', $lpLang) ?></div>
            <div class="section6_item_table">
                <div class="section6_item_row section6_item_row_3">
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_5.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_5_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_5_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_6.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_6_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_6_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                </div>
                <div class="section6_item_row section6_item_row_4">
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_7.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_7_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_7_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_8.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_8_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_8_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="section6_3" class="section6_item section6_item_3">
            <div class="section6_item_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_TITLE_3', $lpLang) ?></div>
            <div class="section6_item_table">
                <div class="section6_item_row section6_item_row_5">
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_9.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_9_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_9_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_10.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_10_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_10_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="section6_3" class="section6_item section6_item_4">
            <div class="section6_item_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_TITLE_4', $lpLang) ?></div>
            <div class="section6_item_table">
                <div class="section6_item_row section6_item_row_6">
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_11.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_11_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_11_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_12.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_12_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_12_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="section6_3" class="section6_item section6_item_5">
            <div class="section6_item_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_TITLE_5', $lpLang) ?></div>
            <div class="section6_item_table">
                <div class="section6_item_row section6_item_row_7">
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_13.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_13_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_13_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_14.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_14_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_14_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                </div>
                <div class="section6_item_row section6_item_row_8">
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_15.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_15_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_15_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_16.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_16_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_16_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="section6_3" class="section6_item section6_item_6">
            <div class="section6_item_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_TITLE_6', $lpLang) ?></div>
            <div class="section6_item_table">
                <div class="section6_item_row section6_item_row_9">
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_17.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_17_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_17_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_18.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_18_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_18_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                </div>
                <div class="section6_item_row section6_item_row_10">
                    <div class="section6_item_cell">
                        <div class="section6_item_img">
                            <img src="<?php echo BASE_URL ?>/img/landing/section6_19.png"/>
                        </div>
                        <div class="section6_item_detail">
                            <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_19_DIV', $lpLang) ?></div>
                            <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_6_ITEM_DETAIL_19_SPAN', $lpLang) ?></span>
                        </div>
                    </div>
                    <div class="section6_item_cell"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="social">
    <div id="social_container">
        <div id="social_title">
            <div id="social_title_1"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_7_TITLE_1', $lpLang) ?></div>
            <div id="social_title_2"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_7_TITLE_2', $lpLang) ?></div>
        </div>

        <div class="social_item">
            <div class="social_item_img social_item_1">
                <img src="<?php echo BASE_URL ?>/img/landing/section7_item_1.png"/>
            </div>
            <div class="social_item_detail">
                <div class="social_item_detail_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_7_ITEM_DETAIL_TITLE_1', $lpLang) ?></div>
                <div class="social_item_detail_txt"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_7_ITEM_DETAIL_TXT_1', $lpLang) ?></div>
            </div>
        </div>

        <div class="social_item social_item_2">
            <div class="social_item_img">
                <img src="<?php echo BASE_URL ?>/img/landing/section7_item_2.png"/>
            </div>
            <div class="social_item_detail">
                <div class="social_item_detail_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_7_ITEM_DETAIL_TITLE_2', $lpLang) ?></div>
                <div class="social_item_detail_txt"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_7_ITEM_DETAIL_TXT_2', $lpLang) ?></div>
            </div>
        </div>

        <div class="social_item social_item_3">
            <div class="social_item_img">
                <img src="<?php echo BASE_URL ?>/img/landing/section7_item_3.png"/>
            </div>
            <div class="social_item_detail">
                <div class="social_item_detail_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_7_ITEM_DETAIL_TITLE_3', $lpLang) ?></div>
                <div class="social_item_detail_txt"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_7_ITEM_DETAIL_TXT_3', $lpLang) ?></div>
            </div>
        </div>
    </div>
</div>
<div id="social_bot">
    <img src="<?php echo BASE_URL ?>/img/landing/section7_bot.png"/>
</div>

<div id="section8_top"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_8_TOP', $lpLang) ?></div>

<div id="section8">
    <div id="section8_container">
        <div id="section8_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_8_TITLE', $lpLang) ?></div>
        <div id="section8_img">
            <img src="<?php echo BASE_URL ?>/img/landing/section8.png"/>
        </div>
        <div id="section8_txt">
            <?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_8_TXT', $lpLang) ?>
            <div id="section8_txt_bot">
                <?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_8_TXT_BOT', $lpLang) ?>
            </div>
        </div>
    </div>
</div>

<div id="contact">
    <div><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_9_TOP_DIV', $lpLang) ?></div>
    <span><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_9_TOP_SPAN', $lpLang) ?></span>
</div>

<div id="section9">
    <div id="section9_container">
        <div id="section9_title"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_9_TITLE', $lpLang) ?></div>
        <div id="section9_detail"><?php echo $this->Common->getlanguageLp('LP_TXT_SECTION_9_DETAIL', $lpLang) ?></div>

        <form action="<?php echo BASE_URL ?>/ajax/sendLdContactMail" id="contact-form" method="POST">
            <div class="form-group">
                <label for="form-control-1"><?php echo $this->Common->getlanguageLp('LP_TXT_NAME', $lpLang) ?> <span class="hints"><?php echo $this->Common->getlanguageLp('LP_TXT_REQUIRED', $lpLang) ?></span></label>
                <input name="data[LP][name]" type="text" class="form-control validate[required]" id="InputName" placeholder="">
            </div>
            
            <?php if($lpLang == 'jpn'): ?>
            <div class="form-group">
                <label for="form-control-1"><?php echo $this->Common->getlanguageLp('LP_TXT_NAME_KANA', $lpLang) ?> <span class="hints"><?php echo $this->Common->getlanguageLp('LP_TXT_REQUIRED', $lpLang) ?></span></label>
                <input name="data[LP][name_kana]" type="text" class="form-control validate[required]" id="InputNameKana" placeholder="">
            </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="form-control-1"><?php echo $this->Common->getlanguageLp('LP_TXT_GROUP_NAME', $lpLang) ?> <span class="hints"><?php echo $this->Common->getlanguageLp('LP_TXT_REQUIRED', $lpLang) ?></span></label>
                <input name="data[LP][group_name]" type="text" class="form-control validate[required]" id="InputGroupName" placeholder="">
            </div>

            <div class="form-group">
                <label for="form-control-1"><?php echo $this->Common->getlanguageLp('LP_TXT_EMAIL', $lpLang) ?> <span class="hints"><?php echo $this->Common->getlanguageLp('LP_TXT_REQUIRED', $lpLang) ?></span></label>
                <input name="data[LP][email]" type="text" class="form-control validate[required,custom[email]]" id="InputEmail" placeholder="">
            </div>

            <div class="form-group">
                <label for="form-control-1"><?php echo $this->Common->getlanguageLp('LP_TXT_EMAIL_CONFIRM', $lpLang) ?> <span class="hints"><?php echo $this->Common->getlanguageLp('LP_TXT_REQUIRED', $lpLang) ?></span></label>
                <input name="data[LP][email_re]" type="text" class="form-control validate[required,equals[InputEmail]]" id="InputEmailRe" placeholder="">
            </div>

            <div class="form-group">
                <label for="form-control-1"><?php echo $this->Common->getlanguageLp('LP_TXT_PHONE', $lpLang) ?> <span class="hints"><?php echo $this->Common->getlanguageLp('LP_TXT_REQUIRED', $lpLang) ?></span></label>
                <input name="data[LP][tel]" type="text" class="form-control validate[required,custom[phone]]" id="InputTel" placeholder="">
            </div>

            <div class="form-group">
                <label for="form-control-1"><?php echo $this->Common->getlanguageLp('LP_TXT_COMMENT', $lpLang) ?> <span class="hints"><?php echo $this->Common->getlanguageLp('LP_TXT_REQUIRED', $lpLang) ?></span></label>
                <textarea name="data[LP][comments]" id="InputComments" class="form-control validate[required]" rows="9"></textarea>
            </div>
            <div class="form-group">
                <input type="hidden" name="data[LP][lang]" value="<?php echo $lpLang ?>"/>
                <p class="text-center footer-bottom"><input type="button" class="btn btn-info btn-lg btn-orange btnLpSendMail" value="<?php echo $this->Common->getlanguageLp('LP_BTN_SEND', $lpLang) ?>"> </p>
            </div>
        </form>

        <div id="model_loader_wrap">
            <img src="<?php echo BASE_URL ?>/img/ajax_loader2.gif"/>
        </div>
    </div>
</div>
