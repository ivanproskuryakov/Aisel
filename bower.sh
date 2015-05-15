rm -rf ./frontend/web/bower_components/
rm -rf ./backend/web/bower_components/

cd ./frontend/
bower install -f
cd ./../
cd ./backend/
bower install -f