mkdir uploads
sudo chown www-data:www-data uploads
chmod 755 uploads
데이터베이스 생성
mysql -u root -p boarddb < database.sql
