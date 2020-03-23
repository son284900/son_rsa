<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/23
 */

namespace Modules\responses;

/**
 * Class ResponseConfig
 *
 * @package Modules\responses
 * @author y_kishimoto
 */
class ResponseConfig
{
    /**
     * コード
     */
    public const CODES = [
        'SUCCESS' =>  '200',
        'UNEXPECTED' => '422',
        'FAILED_VALIDATION' => '999',
        'EXCEPTION_METHOD_NOT_ALLOWED' => '405',
        'EXCEPTION_PAGE_NOT_FOUND' => '404',
        'EXCEPTION_QUERY' => '500'
    ];

    /**
     * メッセージ
     */
    public const MESSAGES = [
        'SUCCESS' =>  'Success',
        'UNEXPECTED' => 'Unexpected Error',
        'FAILED_VALIDATION' => 'Failed Validation',
        'EXCEPTION_METHOD_NOT_ALLOWED' => 'Method Not Allowed.',
        'EXCEPTION_PAGE_NOT_FOUND' => 'Page Not Found.',
        'EXCEPTION_QUERY' => 'Query Exception.'
    ];
}
