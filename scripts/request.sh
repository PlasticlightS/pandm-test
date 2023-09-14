#!/bin/bash

TOKEN=$(curl --location 'http://localhost/api/get-token' --header 'Accept: application/json' --header 'Referer: localhost'| grep -Po '"token": *\K"[^"]*"' | tr -d '"')

curl --location 'http://localhost/api/foo-request' \
--header 'Accept: application/json' \
--header 'Referer: localhost' \
--header "Authorization: Bearer $TOKEN" \
--form 'name="Test 1"' \
--form 'email="john@test.com"' \
--form 'phone="0123456789"'

echo 'Complete'
