<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/01/06
 */

namespace Modules\requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Modules\responses\JsonResponse;
use Illuminate\Http\Response;
use Modules\responses\ResponseConfig;

/**
 * Class RequestAbstract
 * @package Modules\requests
 * @author y_kishimoto
 */
abstract class RequestAbstract extends FormRequest implements RequestInterface
{
    /**
     * リクエスト失敗 バリデーション
     *
     * @param Validator $validator
     * @return Response
     */
    public function failedValidation(Validator $validator): Response
    {
        throw new HttpResponseException(
            JsonResponse::getInstance()
                ->setStatus(JsonResponse::STATUS_NG)
                ->setMessage(ResponseConfig::MESSAGES['FAILED_VALIDATION'])
                ->setCode(ResponseConfig::CODES['FAILED_VALIDATION'])
                ->setData([])
                ->setErrors(['validation' => $validator->errors()->toArray()])
                ->response()
        );
    }

    /**
     * ルート引数 追加
     * @return 配列
     */
    public function validationData()
    {
        return array_merge($this->request->all(), [
            'id' => $this->id,
        ]);
    }
}
