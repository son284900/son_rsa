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

/**
 * Unit Test
 * ShiftMasterController Update API
 *
 * @author y_kishimoto
 */
describe('[ ShiftMasterController Update API ]', function () {

    beforeAll(function () {
        $this->storedId = 0;
        $this->data = [
            "cleaningshiftcode" => "COD",
            "shiftstarttime" => "1000",
            "shiftendtime" => "1900",
            "breakstarttime" => "1300",
            "breakendtime" => "1400",
            "name" => "TEST.UPDATEシフト",
            "shortname" => "T.UPDATE",
            "description" => "UNIT.TEST.UPDATEデータ",
            "sequence" => 100,
            "deleted_at" => null,
        ];
    });

    beforeEach(function () {
        $app = require 'bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    });

    given('url', function () {
        return  'api/v1/master/shifts';
    });

    given('storeRequest', function () {
        $storeData = [
            "cleaningshiftcode" => "COD",
            "shiftstarttime" => "1000",
            "shiftendtime" => "1900",
            "breakstarttime" => "1300",
            "breakendtime" => "1400",
            "name" => "UNIT.TESTシフト",
            "shortname" => "U.TEST",
            "description" => "UNIT.TESTデータ",
            "sequence" => 1,
        ];
        $response = $this->laravel->post($this->url, $storeData);

        return json_decode($response->getContent(), true) ?? [];
    });

    given('deleteRequest', function () {
        $deleted = null;
        if ($this->storedId > 0) {
            $deleted = $this->laravel->delete(
                $this->url,
                ['delete_ids' => [$this->storedId], 'delete_type' => 2]
            );
        }

        return $deleted;
    });

    given('logicalDeleteRequest', function () {
        if ($this->storedId > 0) {
            $deleted = $this->laravel->delete(
                $this->url,
                ['delete_ids' => [$this->storedId], 'delete_type' => 1]
            );
        }
    });

    given('getStoredId', function () {
        $response = $this->storeRequest;
        return $response['result']['data']['shift_master_insert_id'] ?? 0;
    });

    context('[ Response Test ]', function () {

        // 疎通確認 テスト
        describe('Communication Confirmation Test', function () {

            // [Communication Confirmation Test 1] HTTP ステータスコード 200
            it('[Test No. ] Check If The HTTP Status Code Is 200', function () {
                $this->storedId = $this->getStoredId;
                $expected = 200;
                $inspection = $this->laravel->put("{$this->url}/{$this->storedId}", array(array()));

                expect($inspection)->toPassStatus($expected);

                // cleanup
                $this->deleteRequest;
            });
        });

        // リスポンス構造 テスト
        describe('Response Structure Test', function () {

            beforeEach(function () {
                $this->storedId = $this->getStoredId;
            });

            afterEach(function () {
                // cleanup
                $this->deleteRequest;
            });

            // [Response Structure Test 1] 成功
            it('[Test No. ] Check If Response Structure Is Success', function () {
                $response = $this->laravel->put("{$this->url}/{$this->storedId}", $this->data);
                $inspection = json_decode($response->getContent(), true);

                expect($inspection['status'])->toBe(JsonResponse::STATUS_OK);
                expect($inspection['result']['message'])->toBe(ResponseConfig::MESSAGES['SUCCESS']);
                expect($inspection['result']['code'])->toBe(ResponseConfig::CODES['SUCCESS']);
                expect($inspection['result']['data'])->not->toBeNull();
                expect($inspection['result']['errors'])->toBe([]);
            });

            // [Response Structure Test 2] 失敗
            it('[Test No. ] Check If Response Structure Is Failed', function () {
                $response = $this->laravel->put("{$this->url}/{$this->storedId}", array(array()));
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
            beforeEach(function () {
                $this->storedId = $this->getStoredId;
            });

            afterEach(function () {
                // cleanup
                $this->deleteRequest;
            });

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
                $response = $this->laravel->put("{$this->url}/{$this->storedId}", array(array()));
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
                $response = $this->laravel->put("{$this->url}/{$this->storedId}", $form);
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
                    "deleted_at" => [
                        "The deleted at does not match the format Y-m-d H:i:s."
                    ],
                ];

                $form = $this->data;
                $form['shiftstarttime'] = '09000';
                $form['shiftendtime'] = '2500';
                $form['breakstarttime'] = 'aaaa';
                $form['breakendtime'] = '1690';
                $form['deleted_at'] = '1111';
                $response = $this->laravel->put("{$this->url}/{$this->storedId}", $form);
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
                $response = $this->laravel->put("{$this->url}/{$this->storedId}", $form);
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
                $response = $this->laravel->put("{$this->url}/{$this->storedId}", $form);
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
                $response = $this->laravel->put("{$this->url}/{$this->storedId}", $form);
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

            // [Function Exception Test 1]  「 public function update(): void 」
            it('[Test No. ] Check If The Response Of The Function " public function update(): void " Is Correct', function () {
                try {
                    $this->diContainer[ShiftMasterContainer::KEY_MODEL1]->setTable('testing');
                    $this->diContainer[ShiftMasterContainer::KEY_SHIFT_MASTER]->update();
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

            beforeEach(function () {
                $this->storedId = $this->getStoredId;
                $this->logicalDeleteRequest;
            });

            afterEach(function () {
                // cleanup
                $this->deleteRequest;
            });

            // [DB TEST 1]  Updated In DB
            it('[Test No. ] Check If The Updated In DB', function () {
                $this->laravel->put("{$this->url}/{$this->storedId}", $this->data);

                $form = $this->data;
                $form['id'] = $this->storedId;

                expect($this->laravel)->toPassDatabaseHas('m_rscleaningshift', $form, 'rsa');
            });
        });
    });
});
