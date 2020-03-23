<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/25
 */

use Pimple\Container;
use App\Http\Library\shiftmaster\ShiftMasterContainer;
use App\Http\Requests\shiftmaster\ShiftMasterStoreRequest;
use Modules\params\Params;
use Modules\responses\JsonResponse;
use Modules\responses\ResponseConfig;
use App\Models\MasterRsShiftModel;

/**
 * Unit Test
 * ShiftMasterController Store API
 *
 * @author y_kishimoto
 */
describe('[ ShiftMasterController Store API ]', function () {

    beforeAll(function () {
        $this->data = [
            "cleaningshiftcode" => "COD",
            "shiftstarttime" => "1000",
            "shiftendtime" => "1900",
            "breakstarttime" => "1300",
            "breakendtime" => "1400",
            "name" => "UNIT_TESTシフト",
            "shortname" => "UNIT_TEST",
            "description" => "UNIT_TEST用のデータです",
            "sequence" => null,
        ];
    });

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
                $expected = 200;
                $inspection = $this->laravel->post($this->url, array(array()));

                expect($inspection)->toPassStatus($expected);
            });
        });

        // リスポンス構造 テスト
        describe('Response Structure Test', function () {

            // [Response Structure Test 1] 成功
            it('[Test No. ] Check If Response Structure Is Success', function () {
                $response = $this->laravel->post($this->url, $this->data);
                $inspection = json_decode($response->getContent(), true);

                expect($inspection['status'])->toBe(JsonResponse::STATUS_OK);
                expect($inspection['result']['message'])->toBe(ResponseConfig::MESSAGES['SUCCESS']);
                expect($inspection['result']['code'])->toBe(ResponseConfig::CODES['SUCCESS']);
                expect($inspection['result']['data'])->not->toBeNull();
                expect($inspection['result']['errors'])->toBe([]);

                $insertId = $inspection['result']['data']['shift_master_insert_id'] ?? 0;

                if ($insertId > 0) {
                    $deleted = $this->laravel->delete(
                        $this->url,
                        ['delete_ids' => [$insertId], 'delete_type' => 2]
                    );
                }
            });

            // [Response Structure Test 2] 失敗
            it('[Test No. ] Check If Response Structure Is Failed', function () {
                $response = $this->laravel->post($this->url, array(array()));
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
                    "cleaningshiftcode" => [
                        "The cleaningshiftcode field is required."
                    ],
                    "shiftstarttime" =>  [
                        "The shiftstarttime field is required."
                    ],
                    "shiftendtime" => [
                        "The shiftendtime field is required."
                    ],
                    "name" => [
                        "The name field is required."
                    ],
                ];
                $response = $this->laravel->post($this->url, array(array()));
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
                    "cleaningshiftcode" => [
                        "The cleaningshiftcode may not be greater than 3 characters."
                    ],
                    "name" =>  [
                        "The name may not be greater than 30 characters."
                    ],
                    "shortname" => [
                        "The shortname may not be greater than 10 characters."
                    ],
                    "description" => [
                        "The description may not be greater than 200 characters."
                    ],
                ];

                $form = $this->data;
                $form['cleaningshiftcode'] = 'CODD';
                $form['name'] = '0123456789012345678901234567891';
                $form['shortname'] = '01234567891';
                $form['description'] = '012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567891';
                $response = $this->laravel->post($this->url, $form);
                $content = json_decode($response->getContent(), true);
                $inspection = $content['result']['errors']['validation'] ?? [];

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection[$formKey])->toContain($message);
                    }
                }
            });

            // [Form Validation TEST 3]  対象 「時間パラメータ」 内容 「型チェック」
            it('[Test No. ] Check If The Form Validation Item Is "Time Item Parameter" "Time Format Check"', function () {
                $expected =  [
                    "shiftstarttime" => [
                        "The shiftstarttime does not match the format Hi."
                    ],
                    "shiftendtime" =>  [
                        "The shiftendtime does not match the format Hi."
                    ],
                    "breakstarttime" => [
                        "The breakstarttime does not match the format Hi."
                    ],
                    "breakendtime" => [
                        "The breakendtime does not match the format Hi."
                    ],
                ];

                $form = $this->data;
                $form['shiftstarttime'] = '09000';
                $form['shiftendtime'] = '2500';
                $form['breakstarttime'] = 'aaaa';
                $form['breakendtime'] = '1690';
                $response = $this->laravel->post($this->url, $form);
                $content = json_decode($response->getContent(), true);
                $inspection = $content['result']['errors']['validation'] ?? [];

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection[$formKey])->toContain($message);
                    }
                }
            });

            // [Form Validation TEST 4]  対象 勤務終了時刻 「 shiftendtime 」　内容 範囲チェック
            it('[Test No. ] Check If The Form Validation Item Is "shiftendtime Parameter" "Time Border Check"', function () {
                $expected =  [
                    "shiftendtime" => [
                        "shiftendtime is the time after shiftstarttime"
                    ]
                ];

                $form = $this->data;
                $form['shiftendtime'] = '0900';
                $response = $this->laravel->post($this->url, $form);
                $content = json_decode($response->getContent(), true);
                $inspection = $content['result']['errors']['validation'] ?? [];

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection[$formKey])->toContain($message);
                    }
                }
            });

            // [Form Validation TEST 5]  対象 休憩開始時刻 「 breakstarttime 」　内容 範囲チェック
            it('[Test No. ] Check If The Form Validation Item Is "breakstarttime Parameter" "Time Border Check"', function () {
                $expected =  [
                    "breakstarttime" => [
                        "breakstarttime is between time shiftstarttime and shiftendtime"
                    ],
                ];

                $form = $this->data;
                $form['breakstarttime'] = '0900';
                $response = $this->laravel->post($this->url, $form);
                $content = json_decode($response->getContent(), true);
                $inspection = $content['result']['errors']['validation'] ?? [];

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection[$formKey])->toContain($message);
                    }
                }
            });

            // [Form Validation TEST 6]  対象 休憩開始時刻 「 breakendtime 」　内容 範囲チェック
            it('[Test No. ] Check If The Form Validation Item Is "breakendtime Parameter" "Time Border Check"', function () {
                $expected =  [
                    "breakendtime" => [
                        "breakendtime is the time after breakstarttime",
                        "breakendtime is between time shiftstarttime and shiftendtime"
                    ],
                ];

                $form = $this->data;
                $form['breakendtime'] = '0900';
                $response = $this->laravel->post($this->url, $form);
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

                $request = new ShiftMasterStoreRequest();
                $request->merge($this->data);

                $container = new Container();
                $container[ShiftMasterContainer::KEY_REQUEST] = $request;
                $container[ShiftMasterContainer::KEY_PARAMS] = new Params($request);
                $this->diContainer = ShiftMasterContainer::getInstance($container)->getContainer();
            });

            afterEach(function () {
                $this->diContainer[ShiftMasterContainer::KEY_MODEL1]->setTable('m_rscleaningshift');
            });

            // [Function Exception Test 1]  「 public function store(): void 」
            it('[Test No. ] Check If The Response Of The Function " public function store(): void " Is Correct', function () {
                try {
                    $this->diContainer[ShiftMasterContainer::KEY_MODEL1]->setTable('testing');
                    $this->diContainer[ShiftMasterContainer::KEY_SHIFT_MASTER]->store();
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

        describe('DB Stored TEST', function () {

            // [DB TEST 1]  Stored In DB
            it('[Test No. ] Check If The Stored In DB', function () {
                $form = $this->data;
                $response = $this->laravel->post($this->url, $this->data);
                $inspection = json_decode($response->getContent(), true);
                $insertId = $inspection['result']['data']['shift_master_insert_id'] ?? 0;
                $form['id'] = $insertId;
                $form['sequence'] = 1;

                expect($this->laravel)->toPassDatabaseHas('m_rscleaningshift', $form, 'rsa');

                if ($insertId > 0) {
                    $this->laravel->delete(
                        $this->url,
                        ['delete_ids' => [$insertId], 'delete_type' => 2]
                    );
                }
            });
        });
    });
});
