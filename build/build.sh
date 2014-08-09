mkdir /home/upload/code/armycreator/build/$BUILD_NUMBER;
cp -R ./ /home/upload/code/armycreator/build/$BUILD_NUMBER/;
cd /home/upload/code/armycreator/build/$BUILD_NUMBER/;

cp /home/upload/parameters/armycreator.yml app/config/parameters.yml;
rm web/app_dev.php;
rm web/forum;
ln -s /home/upload/code/armycreator_forum web/forum;

composer install;
bower update;

./node_modules/gassetic/bin.js build --env=prod
php app/console cache:clear --env=prod;
# php app/console assets:install --env=prod;
# php app/console assetic:dump --env=prod;

if [[ -d /home/upload/code/armycreator/prod ]]
then
    cp /home/upload/code/armycreator/prod/web/js/* /home/upload/code/armycreator/build/$BUILD_NUMBER/web/js/
    cp /home/upload/code/armycreator/prod/web/css/* /home/upload/code/armycreator/build/$BUILD_NUMBER/web/css/
fi;

if [[ -d /home/upload/code/armycreator/prod_last ]] 
then
    rm /home/upload/code/armycreator/prod_last;
fi;
if [[ -d /home/upload/code/armycreator/prod ]] 
then
    mv /home/upload/code/armycreator/prod /home/upload/code/armycreator/prod_last;
fi;
ln -s /home/upload/code/armycreator/build/$BUILD_NUMBER /home/upload/code/armycreator/prod;
#curl http://www.w40karmycreator.com/forum/ > /dev/null;
rm -rf web/forum/cache/*overall*;
