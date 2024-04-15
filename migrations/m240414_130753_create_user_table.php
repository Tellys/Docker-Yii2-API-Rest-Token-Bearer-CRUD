<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m240414_130753_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'sexo' => $this->string(),
            'image' => $this->string(),
            'ssn' => $this->bigInteger()->unsigned()->notNull()->unique(), //cpf 
            'address' => $this->string(),
            'address_neighborhood' => $this->string(),
            'address_num' => $this->bigInteger()->unsigned(),
            'address_complement' => $this->string(),
            'zip_code'=> $this->bigInteger()->unsigned(),
            'city' => $this->string(),
            'state' => $this->string(),
            'cell_phone' => $this->string(),
            'cell_phone_verified_at' => $this->dateTime(), //->defaultValue(date('Y-m-d H:i:s'))
            'email' => $this->string()->notNull()->unique(),
            'email_verified_at' => $this->dateTime(),
            'password_hash' => $this->string()->notNull(),
            'auth_key' => $this->string(32), //->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
