#!/bin/bash

now=$(date +"%m_%d_%Y")

mv resources/views/app.blade.php resources/views/app.blade.php.$now
cp  resources/views/app.blade.php.test  resources/views/app.blade.php

