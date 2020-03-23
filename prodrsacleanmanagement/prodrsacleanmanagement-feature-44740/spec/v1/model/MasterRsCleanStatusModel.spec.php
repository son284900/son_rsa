<?php

/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/03/03
 */

use App\Http\Library\cleanstatusmaster\CleanStatusMasterSearchBuilder;
use App\Models\MasterRsCleanStatusModel;

/**
 * Unit Test
 * MasterRsCleanStatus Model
 *
 * @author y_kishimoto
 */
describe('[ MasterRsCleanStatusModel ]', function () {

    beforeAll(function () {
        $this->model = new MasterRsCleanStatusModel();
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
                $expected = [1, 2, 3, 4];
                $condition = new CleanStatusMasterSearchBuilder();
                $condition->setKeyword('')
                    ->setLimit(0)
                    ->setOffset(0)
                    ->setSort(json_encode(array(), JSON_FORCE_OBJECT));

                $response = $this->model->getList($condition);
                $content = json_decode($response, true);
                $data = $content ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                expect($inspection)->toBe($expected);
            });

            // [Function "getList()" Test 2] 条件 名称「cleaningstatusname」の昇順  + 論理削除データ含む (数字 > 大文字英字 > 小文字英字 > 文字列)
            it('Test No. ] Check If The Response Sort Ascending Order Of "cleaningstatusname" + Ascending + Including Logical Deletion Data', function () {
                $expected = [3, 2, 1, 4];
                $condition = new CleanStatusMasterSearchBuilder();
                $condition->setKeyword('')
                    ->setLimit(0)
                    ->setOffset(0)
                    ->setSort(json_encode(['cleaningstatusname' => 'asc'], JSON_FORCE_OBJECT))
                    ->setInDeleted(1);

                $response = $this->model->getList($condition);
                $content = json_decode($response, true);
                $data = $content ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                expect($inspection)->toBe($expected);
            });


            // [Function "getList()" Test 3] 条件 名称「cleaningstatuscode」の昇順  + 論理削除データ含む (数字 > 大文字英字 > 小文字英字 > 文字列)
            it('Test No. ] Check If The Response Sort Ascending Order Of "cleaningstatuscode" + Ascending + Including Logical Deletion Data', function () {
                $expected = [3, 4, 1, 2];
                $condition = new CleanStatusMasterSearchBuilder();
                $condition->setKeyword('')
                    ->setLimit(0)
                    ->setOffset(0)
                    ->setSort(json_encode(['cleaningstatuscode' => 'desc'], JSON_FORCE_OBJECT))
                    ->setInDeleted(1);

                $response = $this->model->getList($condition);
                $content = json_decode($response, true);
                $data = $content ?? [];
                $inspection = array_column($data, 'cleanstatusmasterid');

                expect($inspection)->toBe($expected);
            });

            // Function 「 getDetail 」 Test
            describe('Function "getDetail()" Test', function () {

                // [Function "getDetail()" Test 1]  条件 存在するID 指定
                it('[Test No. ] Check The Result Of', function () {
                    $expected = [
                        "cleanstatusmasterid",
                        "systemusercompanyid",
                        "facilityid",
                        "cleaningstatuscode",
                        "cleaningstatusname",
                        "description",
                        "sequence",
                        "createtimestamp",
                        "changetimestamp",
                        "deleted_at",
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
});
