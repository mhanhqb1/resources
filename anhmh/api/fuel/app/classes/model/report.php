<?php

use Fuel\Core\DB;
use Lib\Util;

/**
 * Any query in Model Report
 *
 * @package Model
 * @created 2015-10-16
 * @version 1.0
 * @author Thai Lai
 * @copyright Oceanize INC
 */
class Model_Report extends Model_Abstract
{
    /**
     * Get DAU (daily active user) report.
     *
     * @author thailh
     * @param array $param Input data.
     * @return array Returns the array.
     */
    public static function get_dau_report($param)
    {
        if (empty($param['date_from'])) {
            $param['date_from'] = date('Y-m-1');
        }
        if (empty($param['date_to'])) {
            $days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($param['date_from'])), date('Y', strtotime($param['date_from'])));
            $param['date_to'] = date('Y-m-d', strtotime($param['date_from']) + ($days - 1)*24*60*60);
        }
        $param['date_from'] = self::date_from_val($param['date_from']);
        $param['date_to'] = self::date_to_val($param['date_to']);
        if ($param['date_to'] > time()) {
            $param['date_to'] = self::date_to_val(date('Y-m-d', time()));
        }
        $count_place = Lib\Arr::key_value(          
            DB::select(
                DB::expr("FROM_UNIXTIME(places.created, '%Y-%m-%d') AS day"),
                DB::expr("COUNT(places.id) AS count_place")
            )
            ->from('places')
            ->join('place_informations')
            ->on('places.id', '=', 'place_informations.place_id')
            ->where('places.disable', '0')
            ->where('places.created', '>=', $param['date_from'])
            ->where('places.created', '<=', $param['date_to'])
            ->where('place_informations.language_type', '=', $param['language_type'])
            ->group_by('day')
            ->execute(self::$slave_db)
            ->as_array(), 
            'day',
            'count_place'
        );         
         
        $count_place_pin = Lib\Arr::key_value(
            DB::select(
                'day',
                DB::expr("COUNT(user_id) AS count_place_pin")
            )
            ->from(DB::expr("(                      
                SELECT FROM_UNIXTIME(created, '%Y-%m-%d') AS day, user_id
                FROM place_pins
                WHERE disable = 0
                AND created >= {$param['date_from']}
                AND created <= {$param['date_to']}
                GROUP BY day, user_id                       
            ) AS place_pins"))
            ->group_by('day')
            ->execute(self::$slave_db)
            ->as_array(),
            'day',
            'count_place_pin'
        ); 
        
        $count_want_to_visit = Lib\Arr::key_value(
            DB::select(
                'day',
                DB::expr("COUNT(user_id) AS count_want_to_visit")
            )
            ->from(DB::expr("(                      
                SELECT FROM_UNIXTIME(created, '%Y-%m-%d') AS day, user_id
                FROM place_favorites
                WHERE disable = 0
                AND favorite_type = 1
                AND created >= {$param['date_from']}
                AND created <= {$param['date_to']}
                GROUP BY day, user_id                       
            ) AS place_favorites"))           
            ->group_by('day')
            ->execute(self::$slave_db)
            ->as_array(),
            'day',
            'count_want_to_visit'
        );        
         
        $count_review = Lib\Arr::key_value(  
            DB::select(
                DB::expr("FROM_UNIXTIME(created, '%Y-%m-%d') AS day"),
                DB::expr("COUNT(id) AS count_review")
            )
            ->from('place_reviews')
            ->where('disable', '0')
            ->where('created', '>=', $param['date_from'])
            ->where('created', '<=', $param['date_to'])
            ->group_by('day')
            ->execute(self::$slave_db)
            ->as_array(),
            'day',
            'count_review'
        );
         
        $count_comment = Lib\Arr::key_value(  
            DB::select(
                DB::expr("FROM_UNIXTIME(created, '%Y-%m-%d') AS day"),
                DB::expr("COUNT(id) AS count_comment")
            )
            ->from('place_review_comments')
            ->where('disable', '0')
            ->where('created', '>=', $param['date_from'])
            ->where('created', '<=', $param['date_to'])
            ->group_by('day')
            ->execute(self::$slave_db)
            ->as_array(),
            'day',
            'count_comment'
        );
               
        $result = array();
        for ($day = $param['date_from']; $day <= $param['date_to']; $day += 24*60*60) {
            $ymd = date('Y-m-d', $day);
            $item = array(
                'date' => $ymd,
                'count_place' => 0,
                'count_place_pin' => 0,
                'count_want_to_visit' => 0,
                'count_review' => 0,
                'count_comment' => 0,
            );
            $item['count_place'] =  isset($count_place[$ymd]) ? $count_place[$ymd] : 0;
            $item['count_place_pin'] =  isset($count_place_pin[$ymd]) ? $count_place_pin[$ymd] : 0;
            $item['count_want_to_visit'] =  isset($count_want_to_visit[$ymd]) ? $count_want_to_visit[$ymd] : 0;
            $item['count_review'] =  isset($count_review[$ymd]) ? $count_review[$ymd] : 0;
            $item['count_comment'] =  isset($count_comment[$ymd]) ? $count_comment[$ymd] : 0;
            $result[] = $item;
        }
        return $result; 
    }

    /**
     * Get user report.
     *
     * @author anhmh
     * @param array $param Input data.
     * @return array Returns the array.
     */
    public static function get_user_report($param)
    {
        if (empty($param['date_from'])) {
            $param['date_from'] = date('Y-m');
        }

        if ($param['mode'] == 'month') {
            $modeStep = 'day';
            $dateFormat = 'Y-m-d';
            $dateSqlFormat = '%Y-%m-%d';
        } else {
            $dateFormat = 'm-y';
            $modeStep = 'month';
            $dateSqlFormat = '%m-%y';
            $param['date_from'] = $param['date_from'].'-01-01';
        }

        $param['date_to'] = strtotime($param['date_from']." +1 ".$param['mode']);
        $param['date_from'] = strtotime($param['date_from']);
        $count_user_web = Lib\Arr::key_value(
            DB::select(
                DB::expr("FROM_UNIXTIME(date, '".$dateSqlFormat."') AS day"),
                DB::expr("COUNT(id) AS count_user_web")
            )
                ->from('user_register_logs')
                ->where('type', '=', '1')
                ->where('disable', '=', '0')
                ->where('date', '>=', $param['date_from'])
                ->where('date', '<=', $param['date_to'])
                ->group_by('day')
                ->execute(self::$slave_db)
                ->as_array(),
            'day',
            'count_user_web'
        );
        $count_user_ios = Lib\Arr::key_value(
            DB::select(
                DB::expr("FROM_UNIXTIME(date, '".$dateSqlFormat."') AS day"),
                DB::expr("COUNT(id) AS count_user_ios")
            )
                ->from('user_register_logs')
                ->where('type', '=', '3')
                ->where('disable', '=', '0')
                ->where('date', '>=', $param['date_from'])
                ->where('date', '<=', $param['date_to'])
                ->group_by('day')
                ->execute(self::$slave_db)
                ->as_array(),
            'day',
            'count_user_ios'
        );

        $count_user_android = Lib\Arr::key_value(
            DB::select(
                DB::expr("FROM_UNIXTIME(date, '".$dateSqlFormat."') AS day"),
                DB::expr("COUNT(id) AS count_user_android")
            )
                ->from('user_register_logs')
                ->where('type', '=', '2')
                ->where('disable', '=', '0')
                ->where('date', '>=', $param['date_from'])
                ->where('date', '<=', $param['date_to'])
                ->group_by('day')
                ->execute(self::$slave_db)
                ->as_array(),
            'day',
            'count_user_android'
        );

        $result = array();
        for ($day = $param['date_from']; $day < $param['date_to']; $day = strtotime(date('Y-m-d',$day)." +1 ".$modeStep)) {
            $ymd = date($dateFormat, $day);
            $item = array(
                'time' => $ymd,
                'count_user_1' => 0,
                'count_user_2' => 0,
                'count_user_3' => 0,
            );
            // fix chart bar display 70/01/01
            if ($param['mode'] == 'year') {
                $item['time'] = date('M-y',$day);
            }
            $item['count_user_1'] =  isset($count_user_web[$ymd]) ? $count_user_web[$ymd] : 0;
            $item['count_user_2'] =  isset($count_user_android[$ymd]) ? $count_user_android[$ymd] : 0;
            $item['count_user_3'] =  isset($count_user_ios[$ymd]) ? $count_user_ios[$ymd] : 0;
            $result[] = $item;
        }
        return $result;
    }
    
    /**
     * Get general
     *
     * @author thailh
     * @param array $param Input data.
     * @return array Returns the array.
     */
    public static function general($param)
    {        
        $count_user =      
            DB::select(                
                DB::expr("COUNT(id) AS cnt")
            )
            ->from('user_register_logs')
            ->where('disable', '0')
            ->execute(self::$slave_db)
            ->offsetGet(0);
        
        $count_user_web =      
            DB::select(                
                DB::expr("COUNT(id) AS cnt")
            )
            ->from('user_register_logs')
            ->where('type', '1')
            ->where('disable', '0')
            ->execute(self::$slave_db)
            ->offsetGet(0);
        
        $count_user_ios =      
            DB::select(                
                DB::expr("COUNT(id) AS cnt")
            )
            ->from('user_register_logs')
            ->where('type', '3')
            ->where('disable', '0')
            ->execute(self::$slave_db)
            ->offsetGet(0);
        
        $count_user_android =      
            DB::select(                
                DB::expr("COUNT(id) AS cnt")
            )
            ->from('user_register_logs')
            ->where('type', '2')
            ->where('disable', '0')
            ->execute(self::$slave_db)
            ->offsetGet(0);
        
        $count_place = Lib\Arr::key_value(          
            DB::select(
                'place_informations.language_type',
                DB::expr("COUNT(places.id) AS count_place")
            )
            ->from('places')
            ->join('place_informations')
            ->on('places.id', '=', 'place_informations.place_id')
            ->where('places.disable', '0')
            ->group_by('place_informations.language_type')
            ->execute(self::$slave_db)
            ->as_array(),
            'language_type',
            'count_place'
        );  
         
        $count_place_pin = Lib\Arr::key_value(          
            DB::select(
                'place_informations.language_type',
                DB::expr("COUNT(place_pins.place_id) AS count_place")
            )
            ->from('place_pins')
            ->join('place_informations')
            ->on('place_pins.place_id', '=', 'place_informations.place_id')
            ->where('place_pins.disable', '0')
            ->group_by('place_informations.language_type')
            ->execute(self::$slave_db)
            ->as_array(), 
            'language_type',
            'count_place'
        );       
        
        $count_want_to_visit = 
            DB::select(               
                DB::expr("COUNT(user_id) AS cnt")
            )
            ->from("place_favorites")   
            ->where('place_favorites.disable', '0')
            ->where('place_favorites.favorite_type', '1')
            ->execute(self::$slave_db)
            ->offsetGet(0);
        
        $count_review =   
            DB::select(
                DB::expr("COUNT(id) AS cnt")
            )
            ->from('place_reviews')
            ->where('disable', '0')           
            ->execute(self::$slave_db)
            ->offsetGet(0);        
         
        $count_comment = 
            DB::select(
                DB::expr("COUNT(id) AS cnt")
            )
            ->from('place_review_comments')
            ->where('disable', '0')
            ->execute(self::$slave_db)
            ->offsetGet(0);
        for ($langugeType = 1; $langugeType <= 5; $langugeType++) {
            if (!isset($count_place[$langugeType])) {
                $count_place[$langugeType] = 0;
            }
            if (!isset($count_place_pin[$langugeType])) {
                $count_place_pin[$langugeType] = 0;
            }
        }
        ksort($count_place);
        ksort($count_place_pin);
        $item = array(
            'count_user' => !empty($count_user['cnt']) ? $count_user['cnt'] : 0,
            'count_user_web' => !empty($count_user_web['cnt']) ? $count_user_web['cnt'] : 0,
            'count_user_ios' => !empty($count_user_ios['cnt']) ? $count_user_ios['cnt'] : 0,
            'count_user_android' => !empty($count_user_android['cnt']) ? $count_user_android['cnt'] : 0,
            'count_place' => $count_place,
            'count_place_pin' => $count_place_pin,
            'count_want_to_visit' => !empty($count_want_to_visit['cnt']) ? $count_want_to_visit['cnt'] : 0,
            'count_review' => !empty($count_review['cnt']) ? $count_review['cnt'] : 0,
            'count_comment' => !empty($count_comment['cnt']) ? $count_comment['cnt'] : 0,
        );
        return $item; 
    }
    
}
