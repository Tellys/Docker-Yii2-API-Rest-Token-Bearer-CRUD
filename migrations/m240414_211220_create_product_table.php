<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m240414_211220_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'price' => $this->decimal(10,2),
            'stock' => $this->integer(),
            'image' => $this->string(),
            'user_id' => $this->integer(),
        ]);

        // create index for column `book_id`
        $this->createIndex(
            'idx-product-user_id',
            'product',
            'user_id'
        );

        // add foreign key for table `post`
        $this->addForeignKey(
            'fk-product-user_id',
            'product',
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
        $this->dropTable('{{%product}}');
    }
}
