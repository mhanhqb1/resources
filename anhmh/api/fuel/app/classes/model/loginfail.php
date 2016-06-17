<?php

/**
 * Any query in Model Team
 *
 * @package Model
 * @created 2016-04-13
 * @version 1.0
 * @author AnhMH
 * @copyright Oceanize INC
 */
class Model_Loginfail extends Model_Abstract
{
    /** @var array $_properties field of table */
    protected static $_properties = array(
        'id',
        'ip_address',
        'count',
        'updated',
    );

    /** @var array $_table_name name of table */
    protected static $_table_name = 'user_login_fails';

    /**
     * Add login failed
     *
     * @author AnhMH
     * @param array $param Input data
     * @return bool
     */
    public static function add($ipAddress)
    {
        $self = new self;
        $self->set('ip_address', $ipAddress);
        $self->set('count', '1');
        $self->set('updated', strtotime(date('Y-m-d H:i:s')));
        if ($self->save()) {
            return true;
        }
        return false;
    }

}
