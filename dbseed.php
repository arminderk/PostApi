<?php
require 'bootstrap.php';

$query = <<<EOS
    CREATE TABLE IF NOT EXISTS posts (
        id INT NOT NULL AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        user_id INT DEFAULT NULL,
        created_at TIMESTAMP NOT NULL DEFAULT NOW(),
        updated_at TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(),
        PRIMARY KEY (id),
        FOREIGN KEY (user_id)
                REFERENCES posts(id)
                ON DELETE SET NULL
    ) ENGINE=INNODB;

    INSERT INTO posts
        (title, content)
    VALUES
        ('Post 1', 'This is the first post'),
        ('Post 2', 'This is the second post'),
        ('Post 3', 'This is the third post'),
        ('Post 4', 'This is the fourth post'),
        ('Post 5', 'This is the fifth post');
EOS;

try {
    $createTable = $dbConnection->exec($query);
    echo "DB Seed Successful! \n";
} catch(\PDOException $e) {
    exit($e->getMessage());
}