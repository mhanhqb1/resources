<?php

/**
 * Any query in Model Point Get
 *
 * @package Model
 * @created 2016-03-23
 * @version 1.0
 * @author KienNH
 * @copyright Oceanize INC
 */
class Model_Point_Get extends Model_Abstract {
    
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'name',
        'point',
        'start_date',
        'end_date',
        'disable',
        'created',
        'updated',
    );
    
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events'          => array('before_insert'),
            'mysql_timestamp' => false,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events'          => array('before_update'),
            'mysql_timestamp' => false,
        ),
    );
    
    /** @var array $_table_name name of table */
    protected static $_table_name = 'point_gets';
    
}
