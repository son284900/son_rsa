<?php
/**
 * Created by TAP Co.,Ltd .
 * User: y_kishimoto
 * Date: 2020/02/19
 */

describe("Environment Variables", function () {

    it('overrides testing environments variable PMS Database Host ', function () {
        expect(env("PMS_DB_HOST"))->toEqual("pmsdb");
    });

    it('overrides testing environments variable PMS Database Port', function () {
        expect(env("PMS_DB_PORT"))->toEqual(5432);
    });

    it('overrides testing environments variable RSA Database Host ', function () {
        expect(env("RSA_DB_HOST"))->toEqual("pmsdb");
    });

    it('overrides testing environments variable RSA Database Port', function () {
        expect(env("RSA_DB_PORT"))->toEqual(5432);
    });

    it('is set "APP_ENV=testing"', function() {
        expect(env('APP_ENV'))->toEqual('testing');
    });

});