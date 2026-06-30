<?php 

class Database{
    
    public static function getConnection() : PDO {
        
         return new PDO(
            'mysql:host=localhost;port=3307;dbname=notes;charset=utf8mb4',
            'app',
            'app123',
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
         );
    }    
}