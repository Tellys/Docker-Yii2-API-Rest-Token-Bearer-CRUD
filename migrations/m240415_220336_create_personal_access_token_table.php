<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%personal_access_tokens}}`.
 */
class m240415_220336_create_personal_access_token_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%personal_access_token}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'tokenable_type' => $this->string(),
            'tokenable_id' => $this->bigInteger(),
            'token' => $this->string(64),
            'abilities' => $this->text(),
            'last_used_at' => $this->dateTime(),
            'expires_at' => $this->dateTime(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);

        // create index for column `book_id`
        $this->createIndex(
            'idx-token-user_id',
            'personal_access_token',
            'user_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-token-user_id',
            'personal_access_token',
            'user_id',
            'user',
            'id',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%personal_access_token}}');
    }
}
