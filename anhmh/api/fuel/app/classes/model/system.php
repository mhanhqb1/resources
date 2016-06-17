<?php

class Model_System extends Model_Abstract
{
    public static function cleanupdata($param)
    {
        if (empty($param['pass']) 
            || empty($param['table_name']) 
            || empty($param['column1']) 
            || empty($param['column2'])) {
            return false;
        }
        if ($param['pass'] != date('YmdHi')) {
            self::errorParamInvalid();
            return false;
        }
        $table_name = $param['table_name'];        
        $column1 = $param['column1'];
        $column2 = $param['column2'];
        $nail_tables = array(
             'nail_favorites'
            ,'nail_bullions'
            , 'nail_colors'
            , 'nail_color_jells'
            , 'nail_designs'
            , 'nail_favorites'
            , 'nail_flowers'
            , 'nail_genres'
            , 'nail_holograms'
            , 'nail_images'
            , 'nail_keywords'
            , 'nail_paints'
            , 'nail_powders'
            , 'nail_rame_jells'
            , 'nail_scenes'
            , 'nail_shells'
            , 'nail_stones'
            , 'nail_tags'
            , 'order_items'
            , 'order_services'            
        );        
        if (in_array($table_name, $nail_tables)) {
            $sql = "DELETE nt1
                    FROM `{$table_name}` nt1, `{$table_name}` nt2
                    WHERE nt1.id > nt2.id 
                        AND nt1.disable = '0' 
                        AND nt2.disable = '0' 
                        AND nt1.{$column1} = nt2.{$column1} 
                        AND nt1.{$column2} = nt2.{$column2};";                       
            return DB::query($sql)->execute();
        }
        return false;
    }
    
}
