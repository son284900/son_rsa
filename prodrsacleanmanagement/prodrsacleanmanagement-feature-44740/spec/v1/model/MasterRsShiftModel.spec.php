<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/18
 */

use App\Http\Library\shiftmaster\ShiftMasterSearchBuilder;
use App\Models\MasterRsShiftModel;

/**
 * Unit Test
 * MasterRsShift Model
 *
 * @author y_kishimoto
 */
describe('[ MasterRsShiftModel ]', function () {

    beforeAll(function () {
        $this->model = new MasterRsShiftModel();
    });

    beforeEach(function () {
        $app = require 'bootstrap/app.php';
        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    });

    // 機能テスト
    context('[ Function Test ]', function () {

        // Function 「 getList 」 Test
        describe('Function "getList()" Test', function () {

            // [Function "getList()" Test 1] 条件 デフォルト (ID「id」の昇順 + 論理削除データ含まない)
            it('[Test No. ] Check If The Response Sort Ascending Order Of "ID"', function () {
                $expected = [1, 2, 3, 4, 5, 6, 8, 9, 10, 11, 12, 13, 14];
                $condition = new ShiftMasterSearchBuilder();
                $condition->setKeyword('')
                    ->setLimit(0)
                    ->setOffset(0)
                    ->setSort(json_encode(array(), JSON_FORCE_OBJECT));

                $response = $this->model->getList($condition);
                $content = json_decode($response, true);
                $data = $content ?? [];
                $inspection = array_column($data, 'shiftmasterid');

                expect($inspection)->toBe($expected);
            });

            // [Function "getList()" Test 2] 条件 名称「name」の昇順  + 論理削除データ含む (数字 > 大文字英字 > 小文字英字 > 文字列)
            it('Test No. ] Check If The Response Sort Ascending Order Of "name" + Ascending + Including Logical Deletion Data', function () {
                $expected = [10, 11, 8, 15, 9, 12, 14, 13, 4, 2, 3, 6, 5, 7, 1];
                $condition = new ShiftMasterSearchBuilder();
                $condition->setKeyword('')
                    ->setLimit(0)
                    ->setOffset(0)
                    ->setSort(json_encode(['name' => 'asc'], JSON_FORCE_OBJECT))
                    ->setInDeleted(1);

                $response = $this->model->getList($condition);
                $content = json_decode($response, true);
                $data = $content ?? [];
                $inspection = array_column($data, 'shiftmasterid');

                expect($inspection)->toBe($expected);
            });

            // [Function "getList()" Test 3]  条件 キーワード検索  カタカナ + 論理削除データ含む
            it('[Test No. ] Check The Result Of Keyword Search. Condition is "Katakana" + Including Logical Deletion Data', function () {
                $expected = [1, 2, 3, 4, 5, 6, 7];
                $condition = new ShiftMasterSearchBuilder();
                $condition->setKeyword('シフト')
                    ->setLimit(0)
                    ->setOffset(0)
                    ->setSort(json_encode(array(), JSON_FORCE_OBJECT))
                    ->setInDeleted(1);

                $response = $this->model->getList($condition);
                $content = json_decode($response, true);
                $data = $content ?? [];
                $inspection = array_column($data, 'shiftmasterid');

                foreach ($expected as $key => $item) {
                    expect($inspection)->toContain($item);
                }
            });
        });

        // Function 「 getDetail 」 Test
        describe('Function "getDetail()" Test', function () {

            // [Function "getDetail()" Test 1]  条件 存在するID 指定
            it('[Test No. ] Check The Result Of', function () {
                $expected = [
                    "shiftmasterid",
                    "systemusercompanyid",
                    "facilityid",
                    "cleaningshiftcode",
                    "shiftstarttime",
                    "shiftendtime",
                    "breakstarttime",
                    "breakendtime",
                    "name",
                    "shortname",
                    "description",
                    "sequence",
                    "createuseraccountid",
                    "createtimestamp",
                    "changeuseraccountid",
                    "changetimestamp",
                    "deleted_at"
                ];

                $condition = 1;
                $response = $this->model->getDetail($condition);
                $inspection = json_decode(json_encode($response), true);

                foreach ($expected as $key => $item) {
                    expect($inspection)->toContainKey($item);
                }
            });

            // [Function "getDetail()" Test 2]  条件 存在しないID 指定
            it('[Test No. ] Check The Result Of', function () {
                $condition = 9999999;
                $response = $this->model->getDetail($condition);
                $inspection = json_decode(json_encode($response), true);

                expect($inspection)->toBeNull();
            });
        });
    });
});
