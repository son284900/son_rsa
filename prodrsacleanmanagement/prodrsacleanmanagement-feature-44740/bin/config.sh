#!/bin/bash
## -----------------------------
## |  RSA PROJECT              |
## -----------------------------
## -- MAINTAINER --
##  y_kishimoto<yumiko.kishimoto@tap-ic.co.jp>
##
## -- CREATED DATE --
##　2020/01/08
##
## -- PERMISSION DENIED --
##  $ cd project/to/
##  $ chmod +x Makefile
##
## -----------------------------

SCRIPT_DIR=$(cd $(dirname $0); pwd)

HEADER="Content-Type: application/json"

PORT=8000

VERSION=v1

API_URL=http://localhost:${PORT}/api/${VERSION}
echo $API_URL


url_encode() {
  local input="$*"
  echo "$input" |
    nkf -W8MQ |
    sed 's/=$//' |
    tr '=' '%' |
    paste -s -d '\0' - |
    sed -e 's/%7E/~/g' \
        -e 's/%5F/_/g' \
        -e 's/%2D/-/g' \
        -e 's/%2E/./g'

}
