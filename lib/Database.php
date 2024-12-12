<?php

$db = new SQLite3(
    dirname(__DIR__) . "/data/wordsmith.sqlite",
    SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE
);

$db->enableExceptions(true);

$db->query(
    'CREATE TABLE IF NOT EXISTS "user_account"(
       "user_account_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
       "name" VARCHAR(75),
       "username" VARCHAR(50),
       "email" VARCHAR(50),
       "password" VARCHAR(75),
       "date_added" DATETIME,
       "last_active" DATETIME
    )'
);

$db->query(
    'CREATE TABLE IF NOT EXISTS "favorites"(
     "favorite_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
     "user_id" INTEGER,
     "word" VARCHAR(100) NOT NULL,
     "phonetic" VARCHAR(100),
     "audio" VARCHAR(100),
     "date_added" DATETIME,
     FOREIGN KEY(user_id) REFERENCES user_account(user_account_id)
   )'
);

$db->query(
    'CREATE TABLE IF NOT EXISTS "word_definition"(
     "word_defintion_id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
     "favorite_id" INTEGER,
     "definition" TEXT,
     "parts_of_speech" VARCHAR(75),
     "example" VARCHAR(255),
     FOREIGN KEY(favorite_id) REFERENCES favorites(favorite_id)
  )'
);

?>
