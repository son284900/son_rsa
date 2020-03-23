<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/04
 */

use Pimple\Container;
use App\Http\Library\cleanstatusmaster\CleanStatusMasterContainer;
use App\Http\Requests\cleanstatusmaster\CleanStatusMasterStoreRequest;
use Modules\params\Params;
use Modules\responses\JsonResponse;
use Modules\responses\ResponseConfig;

/**
 * Unit Test
 * CleanStatusMasterController Update API
 *
 * @author y_kishimoto
 */
describe('[ CleanStatusMasterController Update API ]', function () {

    beforeAll(function () {
        $this->existId = 3;
        $this->existData = [
            "cleaningstatusname" => "未清掃",
            "description" => null,
            "sequence" => 3,
            "deleted_at" => null,
        ];

        $this->updateData = [
            "cleaningstatusname" => "Not Cleaned",
            "description" => 'Description',
            "sequence" => 1,
            "deleted_at" => null,
        ];
    });

    beforeEach(function () {
        $app = require 'bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    });

    given('url', function () {
        return  'api/v1/master/clean/statuses';
    });

    given('restoreData', function () {
        $this->laravel->put("{$this->url}/{$this->existId}", $this->existData);
    });

    context('[ Response Test ]', function () {

        // 疎通確認 テスト
        describe('Communication Confirmation Test', function () {

            // [Communication Confirmation Test 1] HTTP ステータスコード 200
            it('[Test No. ] Check If The HTTP Status Code Is 200', function () {
                $expected = 200;
                $inspection = $this->laravel->put("{$this->url}/{$this->existId}", array(array()));

                expect($inspection)->toPassStatus($expected);
            });
        });

        // リスポンス構造 テスト
        describe('Response Structure Test', function () {

            // [Response Structure Test 1] 成功
            it('[Test No. ] Check If Response Structure Is Success', function () {
                $response = $this->laravel->put("{$this->url}/{$this->existId}", $this->existData);
                $inspection = json_decode($response->getContent(), true);

                expect($inspection['status'])->toBe(JsonResponse::STATUS_OK);
                expect($inspection['result']['message'])->toBe(ResponseConfig::MESSAGES['SUCCESS']);
                expect($inspection['result']['code'])->toBe(ResponseConfig::CODES['SUCCESS']);
                expect($inspection['result']['data'])->not->toBeNull();
                expect($inspection['result']['errors'])->toBe([]);
            });

            // [Response Structure Test 2] 失敗
            it('[Test No. ] Check If Response Structure Is Failed', function () {
                $response = $this->laravel->put("{$this->url}/{$this->existId}", array(array()));
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

            // [Form Validation TEST 1]  対象 「必須項目のパラメータ」 内容 「fieldの存在チェック」
            it('[Test No. ] Check If The Form Validation Item Is "Required Item Parameter" "Field Existence Check"', function () {
                $expected =  [
                    "cleaningstatusname" => [
                        "The cleaningstatusname field is required."
                    ]
                ];
                $response = $this->laravel->put("{$this->url}/{$this->existId}", array(array()));
                $content = json_decode($response->getContent(), true);
                $inspection = $content['result']['errors']['validation'] ?? [];

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection[$formKey])->toContain($message);
                    }
                }
            });

            // [Form Validation TEST 2]  対象 「文字数制限のあるパラメータ」 内容 「文字数チェック」
            it('[Test No. ] Check If The Form Validation Item Is "Character Limit Item Parameter" "Character Limit Check"', function () {
                $expected =  [
                    "cleaningstatusname" =>  [
                        "The cleaningstatusname may not be greater than 15 characters."
                    ],
                    "description" => [
                        "The description may not be greater than 200 characters."
                    ],
                ];

                $form = $this->existData;
                $form['cleaningstatusname'] = '0123456789012345678901234567891';
                $form['description'] = '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567891';
                $response = $this->laravel->put("{$this->url}/{$this->existId}", $form);
                $content = json_decode($response->getContent(), true);
                $inspection = $content['result']['errors']['validation'] ?? [];

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection[$formKey])->toContain($message);
                    }
                }
            });

            // [Form Validation TEST 3]  対象 「型指定のあるパラメータ」 内容 「型チェック」
            it('[Test No. ] Check If The Form Validation Item Is "Time Item Parameter" "Time Format Check"', function () {
                $expected =  [
                    "cleaningstatusname" => [
                        "The cleaningstatusname must be a string."
                    ],
                    "description" =>  [
                        "The description must be a string."
                    ],
                    "sequence" => [
                        "The sequence must be an integer."
                    ],
                    "deleted_at" => [
                        "The deleted at does not match the format Y-m-d H:i:s."
                    ],
                ];

                $form = $this->existData;
                $form['cleaningstatusname'] = 111;
                $form['description'] = 111;
                $form['sequence'] = 'aaa';
                $form['deleted_at'] = '1111';
                $response = $this->laravel->put("{$this->url}/{$this->existId}", $form);
                $content = json_decode($response->getContent(), true);
                $inspection = $content['result']['errors']['validation'] ?? [];

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection[$formKey])->toContain($message);
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

                $request = new CleanStatusMasterStoreRequest();
                $request->merge($this->existData);

                $container = new Container();
                $container[CleanStatusMasterContainer::KEY_REQUEST] = $request;
                $container[CleanStatusMasterContainer::KEY_PARAMS] = new Params($request);
                $this->diContainer = CleanStatusMasterContainer::getInstance($container)->getContainer();
            });

            afterEach(function () {
                $this->diContainer[CleanStatusMasterContainer::KEY_MODEL1]->setTable('m_rscleaningstatus');
            });

            // [Function Exception Test 1]  「 public function update(): void 」
            it('[Test No. ] Check If The Response Of The Function " public function update(): void " Is Correct', function () {
                try {
                    $this->diContainer[CleanStatusMasterContainer::KEY_MODEL1]->setTable('testing');
                    $this->diContainer[CleanStatusMasterContainer::KEY_CLEAN_STATUS_MASTER]->update();
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

    // DBテスト
    context('[ DB Test ]', function () {

        describe('DB Updated TEST', function () {

            afterEach(function () {
                // restore
                $this->restoreData;
            });

            // [DB TEST 1]  Updated In DB
            it('[Test No. ] Check If The Updated In DB', function () {
                $this->laravel->put("{$this->url}/{$this->existId}", $this->updateData);

                $form = $this->updateData;
                $form['id'] = $this->existId;

                expect($this->laravel)->toPassDatabaseHas('m_rscleaningstatus', $form, 'rsa');
            });
        });
    });
});
