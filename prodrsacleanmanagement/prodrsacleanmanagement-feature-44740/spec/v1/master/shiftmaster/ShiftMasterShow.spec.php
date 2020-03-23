<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/25
 */

use Pimple\Container;
use App\Http\Library\shiftmaster\ShiftMasterContainer;
use App\Http\Requests\shiftmaster\ShiftMasterShowRequest;
use Modules\params\Params;
use Modules\responses\JsonResponse;
use Modules\responses\ResponseConfig;

/**
 * Unit Test
 * ShiftMasterController Show API
 *
 * @author y_kishimoto
 */
describe('[ ShiftMasterController Show API ]', function () {

    beforeEach(function () {
        $app = require 'bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    });

    given('url', function () {
        return  'api/v1/master/shifts';
    });

    context('[ Response Test ]', function () {

        // 疎通確認 テスト
        describe('Communication Confirmation Test', function () {

            // [Communication Confirmation Test 1] HTTP ステータスコード 200
            it('[Test No. ] Check If The HTTP Status Code Is 200', function () {
                $id = 1;
                $expected = 200;
                $inspection = $this->laravel->get("{$this->url}/{$id}");

                expect($inspection)->toPassStatus($expected);
            });
        });

        // リスポンス構造 テスト
        describe('Response Structure Test', function () {

            // [Response Structure Test 1] 成功
            it('[Test No. ] Check If Response Structure Is Success', function () {
                $id = 1;
                $response = $this->laravel->get("{$this->url}/{$id}");
                $inspection = json_decode($response->getContent(), true);

                expect($inspection['status'])->toBe(JsonResponse::STATUS_OK);
                expect($inspection['result']['message'])->toBe(ResponseConfig::MESSAGES['SUCCESS']);
                expect($inspection['result']['code'])->toBe(ResponseConfig::CODES['SUCCESS']);
                expect($inspection['result']['data'])->not->toBeNull();
                expect($inspection['result']['errors'])->toBe([]);
            });

            // [Response Structure Test 2] 失敗
            it('[Test No. ] Check If Response Structure Is Failed', function () {
                $id = 999999999;
                $response = $this->laravel->get("{$this->url}/{$id}");
                $inspection = json_decode($response->getContent(), true);

                expect($inspection['status'])->toBe(JsonResponse::STATUS_NG);
                expect($inspection['result']['message'])->not->toBe(ResponseConfig::MESSAGES['SUCCESS']);
                expect($inspection['result']['code'])->not->toBe(ResponseConfig::CODES['SUCCESS']);
                expect($inspection['result']['data'])->toBe(array());
                expect($inspection['result']['errors'])->not->toBeNull();
            });
        });
    });

    context('[ Request Test ]', function () {

        // フォームバリデーション テスト
        describe('Form Validation TEST', function () {

            // [Form Validation TEST 1]  対象「id」　内容 データ型チェック
            it('[Test No. ] Check If The Form Validation Item Is "id" Data Type Check', function () {
                $id = 'a';
                $response = $this->laravel->get("{$this->url}/{$id}");
                $inspection = json_decode($response->getContent(), true);

                expect($inspection['status'])->toBe(JsonResponse::STATUS_NG);
                expect($inspection['result']['message'])->toBe(ResponseConfig::MESSAGES['EXCEPTION_QUERY']);
                expect($inspection['result']['code'])->toBe(ResponseConfig::CODES['EXCEPTION_QUERY']);
                expect($inspection['result']['data'])->toBe(array());
                expect(array_key_exists('exception', $inspection['result']['errors']))->toBe(true);
            });

            // [Form Validation TEST 2]  対象「id」　内容 データ存在チェック
            it('[Test No. ] Check If The Form Validation Item Is "id" Data Type Check', function () {
                $id = 999999999;
                $expected = [
                    "id" => [
                        "id data does not exist."
                    ]
                ];
                $response = $this->laravel->get("{$this->url}/{$id}");
                $inspection = json_decode($response->getContent(), true);

                expect($inspection['status'])->toBe(JsonResponse::STATUS_NG);
                expect($inspection['result']['message'])->toBe(ResponseConfig::MESSAGES['FAILED_VALIDATION']);
                expect($inspection['result']['code'])->toBe(ResponseConfig::CODES['FAILED_VALIDATION']);
                expect($inspection['result']['data'])->toBe(array());

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection['result']['errors']['validation'][$formKey])->toContain($message);
                    }
                }
            });
        });
    });

    // 例外テスト
    context('[ Exception Test ]', function () {

        describe('Function Exception Test', function () {
            beforeEach(function () {
                JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

                $request = new ShiftMasterShowRequest();
                $request->merge(array(
                    'id' => 1,
                ));

                $container = new Container();
                $container[ShiftMasterContainer::KEY_REQUEST] = $request;
                $container[ShiftMasterContainer::KEY_PARAMS] = new Params($request);
                $this->diContainer = ShiftMasterContainer::getInstance($container)->getContainer();
            });

            afterEach(function () {
                $this->diContainer[ShiftMasterContainer::KEY_MODEL1]->setTable('m_rscleaningshift');
            });

            // [Function Exception Test 1]  「 public function show(): void 」
            it('[Test No. ] Check If The Response Of The Function " public function show(): void " Is Correct', function () {
                try {
                    $this->diContainer[ShiftMasterContainer::KEY_MODEL1]->setTable('testing');
                    $this->diContainer[ShiftMasterContainer::KEY_SHIFT_MASTER]->show();
                } catch (\Exception $e) {
                }

                $inspection = json_decode(JsonResponse::getInstance()->response()->getContent(), true);

                expect($inspection['status'])->toBe(JsonResponse::STATUS_NG);
                expect($inspection['result']['message'])->toBe(ResponseConfig::MESSAGES['UNEXPECTED']);
                expect($inspection['result']['code'])->toBe(ResponseConfig::CODES['UNEXPECTED']);
                expect(array_key_exists('exception', $inspection['result']['errors']))->toBe(true);
            });
        });
    });

});
