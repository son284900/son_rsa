<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/03
 */

use Pimple\Container;
use App\Http\Library\cleanstatusmaster\CleanStatusMasterContainer;
use App\Http\Requests\cleanstatusmaster\CleanStatusMasterListRequest;
use Modules\params\Params;
use Modules\responses\JsonResponse;
use Modules\responses\ResponseConfig;

/**
 * Unit Test
 * CleanStatusMasterController List API
 *
 * @author y_kishimoto
 */
describe('[ CleanStatusMasterController List API ]', function () {

    beforeEach(function () {
        $app = require 'bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    });

    given('url', function () {
        return  'api/v1/master/clean/statuses';
    });

    given('emptySort', function () {
        return  json_encode(array(), JSON_FORCE_OBJECT);
    });

    given('requestDefault', function () {
        $response = $this->laravel->get("{$this->url}?q&limit=0&offset=0&sort={$this->emptySort}");

        return $response;
    });

    given('setDeleteData', function () {
        $this->laravel->delete(
            $this->url,
            ['delete_ids' => [3], 'delete_type' => 1]
        );
    });

    given('restoreDeleteData', function () {
        $data = [
            "cleaningstatuscode" => "TODO",
            "cleaningstatusname" => "未清掃",
            "description" => null,
            "sequence" => 3,
            "deleted_at" => null,
        ];
        $this->laravel->put("{$this->url}/3", $data);
    });

    context('[ Response Test ]', function () {
        // 疎通確認 テスト
        describe('Communication Confirmation Test', function () {

            // [Communication Confirmation Test 1] HTTP ステータスコード 200
            it('[Test No. ] Check If The HTTP Status Code Is 200', function () {
                $expected = 200;
                $inspection = $this->requestDefault;

                expect($inspection)->toPassStatus($expected);
            });
        });

        // リスポンス構造 テスト
        describe('Response Structure Test', function () {

            // [Response Structure Test 1] 成功
            it('[Test No. ] Check If Response Structure Is Success', function () {
                $response = $this->requestDefault;
                $inspection = json_decode($response->getContent(), true);

                expect($inspection['status'])->toBe(JsonResponse::STATUS_OK);
                expect($inspection['result']['message'])->toBe(ResponseConfig::MESSAGES['SUCCESS']);
                expect($inspection['result']['code'])->toBe(ResponseConfig::CODES['SUCCESS']);
                expect($inspection['result']['data'])->not->toBeNull();
                expect($inspection['result']['errors'])->toBe([]);
            });

            // [Response Structure Test 2] 失敗
            it('[Test No. ] Check If Response Structure Is Failed', function () {
                $response = $this->laravel->get("{$this->url}?q&limit=&offset=&sort=");
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

        // 条件分岐 テスト
        describe('Conditional Branch Test', function () {

            beforeEach(function () {
                $this->setDeleteData;
            });

            afterEach(function () {
                $this->restoreDeleteData;
            });

            // [Conditional Branch Test 1] 条件 論理削除データ含む
            it('[Test No. ] Check If The Response Conditions Including Deleted Data', function () {
                $response = $this->laravel->get("{$this->url}?q&limit=0&offset=0&sort={$this->emptySort}&in_deleted=1");
                $content = json_decode($response->getContent(), true);
                $data = $content['result']['data'] ?? [];
                $inspection = array_column($data, 'deleted_at');

                expect(preg_grep('|\d{4}\-\d{1,2}\-\d{1,2}|', $inspection))->not->toBeEmpty();
            });

            // [Conditional Branch Test 2]  条件 論理削除データ含まない
            it('[Test No. ] Check If The Response Conditions Non Deleted Data', function () {
                $response = $this->laravel->get("{$this->url}?q&limit=0&offset=0&sort={$this->emptySort}&in_deleted=0");
                $content = json_decode($response->getContent(), true);
                $data = $content['result']['data'] ?? [];
                $inspection = array_column($data, 'deleted_at');

                expect(preg_grep('|\d{4}\-\d{1,2}\-\d{1,2}|', $inspection))->toBeEmpty();
            });

            // [Conditional Branch Test 3] 条件 並び替え デフォルト (ID「id」の昇順 + 論理削除データ含まない)
            it('[Test No. ] Check If The Response Sort Ascending Order Of "ID"', function () {
                $expected = [1, 2, 4];
                $response = $this->requestDefault;
                $content = json_decode($response->getContent(), true);
                $data = $content['result']['data'] ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                expect($inspection)->toBe($expected);
            });

            // [Conditional Branch Test 4]  条件 並び替え 並び順項目「sequence」の昇順 +  ID「id」の昇順 + 論理削除データ含む
            it('[Test No. ] Check If The Response Sort Ascending Order Of "sequence" + Ascending Order Of "ID" + Including Logical Deletion Data', function () {
                $expected = [1, 2, 3, 4];
                $sort = json_encode(['sequence' => 'asc', 'id' => 'asc'], JSON_FORCE_OBJECT);
                $response = $this->laravel->get("{$this->url}?q&limit=0&offset=0&sort={$sort}&in_deleted=1");
                $content = json_decode($response->getContent(), true);
                $data = $content['result']['data'] ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                expect($inspection)->toBe($expected);
            });

            // [Conditional Branch Test 5]  条件 並び替え 名称「cleaningstatusname」の昇順  + 論理削除データ含む (数字 > 大文字英字 > 小文字英字 > 文字列)
            it('[Test No. ] Check If The Response Sort Ascending Order Of "cleaningstatusname" + Ascending + Including Logical Deletion Data', function () {
                $expected = [3, 2, 1, 4];
                $sort = json_encode(['cleaningstatusname' => 'asc'], JSON_FORCE_OBJECT);
                $response = $this->laravel->get("{$this->url}?q&limit=0&offset=0&sort={$sort}&in_deleted=1");
                $content = json_decode($response->getContent(), true);
                $data = $content['result']['data'] ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                expect($inspection)->toBe($expected);
            });

            // [Conditional Branch Test 6]  条件 キーワード検索  英字 + 論理削除データ含む
            it('[Test No. ] Check The Result Of Keyword Search. Condition is "Alphabetic" + Including Logical Deletion Data', function () {
                $data = [
                    "cleaningstatusname" => "a",
                    "sequence" => 3,
                    "deleted_at" => '2020-03-03 00:00:00',
                ];
                $this->laravel->put("{$this->url}/3", $data);

                $expected = [3];
                $word = 'a';
                $response = $this->laravel->get("{$this->url}?q={$word}&limit=0&offset=0&sort={$this->emptySort}&in_deleted=1");
                $content = json_decode($response->getContent(), true);
                $data = $content['result']['data'] ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                foreach ($expected as $key => $item) {
                    expect($inspection)->toContain($item);
                }
            });

            // [Conditional Branch Test 7]  条件 キーワード検索  数字 + 論理削除データ含む
            it('[Test No. ] Check The Result Of Keyword Search. Condition is "Numbers" + Including Logical Deletion Data', function () {
                $data = [
                    "cleaningstatusname" => "1",
                    "sequence" => 3,
                    "deleted_at" => '2020-03-03 00:00:00',
                ];
                $this->laravel->put("{$this->url}/3", $data);

                $expected = [3];
                $word = 1;
                $response = $this->laravel->get("{$this->url}?q={$word}&limit=0&offset=0&sort={$this->emptySort}&in_deleted=1");
                $content = json_decode($response->getContent(), true);
                $data = $content['result']['data'] ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                foreach ($expected as $key => $item) {
                    expect($inspection)->toContain($item);
                }
            });

            // [Conditional Branch Test 8]  条件 キーワード検索  漢字 + 論理削除データ含む
            it('[Test No. ] Check The Result Of Keyword Search. Condition is "Chinese characters" + Including Logical Deletion Data', function () {
                $expected = [1];
                $word = '済';
                $response = $this->laravel->get("{$this->url}?q={$word}&limit=0&offset=0&sort={$this->emptySort}&in_deleted=1");
                $content = json_decode($response->getContent(), true);
                $data = $content['result']['data'] ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                foreach ($expected as $key => $item) {
                    expect($inspection)->toContain($item);
                }
            });

            // [Conditional Branch Test 9]  条件 キーワード検索  ひらがな + 論理削除データ含む
            it('[Test No. ] Check The Result Of Keyword Search. Condition is "Hiragana" + Including Logical Deletion Data', function () {
                $data = [
                    "cleaningstatusname" => "あ",
                    "sequence" => 3,
                    "deleted_at" => '2020-03-03 00:00:00',
                ];
                $this->laravel->put("{$this->url}/3", $data);

                $expected = [3];
                $word = 'あ';
                $response = $this->laravel->get("{$this->url}?q={$word}&limit=0&offset=0&sort={$this->emptySort}&in_deleted=1");
                $content = json_decode($response->getContent(), true);
                $data = $content['result']['data'] ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                foreach ($expected as $key => $item) {
                    expect($inspection)->toContain($item);
                }
            });

            // [Conditional Branch Test 10]  条件 キーワード検索  カタカナ + 論理削除データ含む
            it('[Test No. ] Check The Result Of Keyword Search. Condition is "Katakana" + Including Logical Deletion Data', function () {
                $data = [
                    "cleaningstatusname" => "アウト",
                    "sequence" => 3,
                    "deleted_at" => '2020-03-03 00:00:00',
                ];
                $this->laravel->put("{$this->url}/3", $data);

                $expected = [3];
                $word = 'アウト';
                $response = $this->laravel->get("{$this->url}?q={$word}&limit=0&offset=0&sort={$this->emptySort}&in_deleted=1");
                $content = json_decode($response->getContent(), true);
                $data = $content['result']['data'] ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                foreach ($expected as $key => $item) {
                    expect($inspection)->toContain($item);
                }
            });
        });

        // フォームバリデーション テスト
        describe('Form Validation TEST', function () {

            // [Form Validation TEST 1]  対象 「必須項目のパラメータ」 内容 「fieldの存在チェック」
            it('[Test No. ] Check If The Form Validation Item Is "Required Item Parameter" "Field Existence Check"', function () {
                $expected =  [
                    "q" => [
                        "The q field must be present."
                    ],
                    "limit" =>  [
                        "The limit field must be present."
                    ],
                    "offset" => [
                        "The offset field must be present."
                    ],
                    "sort" => [
                        "The sort field must be present."
                    ]
                ];
                $response = $this->laravel->get("{$this->url}");
                $content = json_decode($response->getContent(), true);
                $inspection = $content['result']['errors']['validation'] ?? [];

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection[$formKey])->toContain($message);
                    }
                }
            });

            // [Form Validation TEST 2]  対象「sort」　内容 データ型チェック
            it('[Test No. ] Check If The Form Validation Item Is "sort" "Data Type Check', function () {
                $expected = [
                    "sort" => [
                        "The sort must be a valid JSON string."
                    ]
                ];
                $response = $this->laravel->get("{$this->url}?q&limit=0&offset=0&sort=1");
                $content = json_decode($response->getContent(), true);
                $inspection = $content['result']['errors']['validation'] ?? [];

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection[$formKey])->toContain($message);
                    }
                }
            });

            // [Form Validation TEST 3]  対象「in_deleted」 内容 データ型チェック
            it('[Test No. ] Check If The Form Validation Item Is "in_deleted" "Data Type Check', function () {
                $expected = ["in_deleted" => [
                    "The in deleted must be an integer.",
                    "The selected in deleted is invalid."
                ]];
                $response = $this->laravel->get("{$this->url}?q&limit=0&offset=0&sort={$this->emptySort}&in_deleted=a");
                $content = json_decode($response->getContent(), true);
                $inspection = $content['result']['errors']['validation'] ?? [];

                foreach ($expected as $formKey => $messages) {
                    foreach ($messages as $key => $message) {
                        expect($inspection[$formKey])->toContain($message);
                    }
                }
            });

            // [Form Validation TEST 4]  対象「in_deleted」 内容 範囲チェック
            it('[Test No. ] Check If The Form Validation Item Is "in_deleted" "Range Check', function () {
                $expected = ["in_deleted" => [
                    "The selected in deleted is invalid."
                ]];
                $response = $this->laravel->get("{$this->url}?q&limit=0&offset=0&sort={$this->emptySort}&in_deleted=2");
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

    // // 例外テスト
    context('[ Exception Test ]', function () {

        describe('Function Exception Test', function () {
            beforeEach(function () {
                JsonResponse::getInstance()->setResponse(JsonResponse::getTemplate());

                $request = new CleanStatusMasterListRequest();
                $request->merge(array(
                    'q' => '',
                    'limit' => 0,
                    'offset' => 0,
                    'sort' => json_encode(array(), JSON_FORCE_OBJECT)
                ));

                $container = new Container();
                $container[CleanStatusMasterContainer::KEY_REQUEST] = $request;
                $container[CleanStatusMasterContainer::KEY_PARAMS] = new Params($request);
                $this->diContainer = CleanStatusMasterContainer::getInstance($container)->getContainer();
            });

            afterEach(function () {
                $this->diContainer[CleanStatusMasterContainer::KEY_MODEL1]->setTable('m_rscleaningstatus');
            });

            // [Function Exception Test 1]  「 public function list(): void 」
            it('[Test No. ] Check If The Response Of The Function " public function list(): void " Is Correct', function () {
                try {
                    $this->diContainer[CleanStatusMasterContainer::KEY_MODEL1]->setTable('testing');
                    $this->diContainer[CleanStatusMasterContainer::KEY_CLEAN_STATUS_MASTER]->list();
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
