#!/bin/sh

database=keywords.db

echo "getting file.."
wget ftp://ftp.sunet.se/pub/tv+movies/imdb/keywords.list.gz > /dev/null 2>&1
echo "extracting.."
gunzip -f keywords.list.gz

echo "processing.."
sed -e '1,/8: THE KEYWORDS LIST/d' keywords.list | sed -e '1,2d' | sed -e '/{\|(VG)/d' | sed 's/"//g' > only_keywords_latin.list
iconv -f ISO-8859-15 -t utf-8 only_keywords_latin.list > only_keywords.list
cat only_keywords.list | cut -f 1 | uniq -c | sort -n | sed -e '1,/^\s*9/d' | sed 's/^\s*[0-9][0-9]*\s//' > titles.list

echo "preparing titles sql.."
echo "BEGIN TRANSACTION;" > titles.sql
sed "s/'/''/g" titles.list | sed "s/^/INSERT INTO movies (name) values ('/;s/$/');/"  >> titles.sql
echo "END TRANSACTION;" >> titles.sql

echo "preparing keywords sql.."
echo "BEGIN TRANSACTION;" > keywords.sql
sed "s/'/''/g" only_keywords.list | sed "s/\t\t*/','/"| sed "s/^/INSERT INTO keywords (name,kw) values ('/;s/$/');/"  >> keywords.sql
echo "END TRANSACTION;" >> keywords.sql

echo "creating tables.."
echo "drop table if exists movies; drop table if exists keywords; create table movies (name text primary key); create table keywords (name text, kw text);" | sqlite3 $database

echo "inserting titles.."
sqlite3 $database < titles.sql > /dev/null 2>&1
echo "inserting keywords.."
sqlite3 $database < keywords.sql > /dev/null 2>&1

echo "cleanup.."
rm keywords.list titles.list only_keywords_latin.list only_keywords.list titles.sql keywords.sql
