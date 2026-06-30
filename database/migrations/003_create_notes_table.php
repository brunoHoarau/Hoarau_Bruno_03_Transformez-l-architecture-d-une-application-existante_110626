<?php

return new class
{
    public function up(PDO $pdo): void
    {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS notes (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

                user_id BIGINT UNSIGNED NOT NULL,
                tag_id BIGINT UNSIGNED NOT NULL,

                text TEXT NOT NULL,

                created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                CONSTRAINT fk_notes_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                CONSTRAINT fk_notes_tag FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
            )
        ");
    }
};