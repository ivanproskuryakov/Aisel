#!/usr/bin/env bash
rm -rf ./web/media/product/*
rm -rf ./backend/web/bower_components/
rm -rf ./backend/web/bower_components/

cd ./frontend/
bower install -f --allow-root
cd ./../
cd ./backend/
bower install -f --allow-root