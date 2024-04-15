<?php

use yii\db\Migration;

/**
 * Class m240414_211403_seed_product_table
 */
class m240414_211403_seed_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $this->insert(
                'product',
                [
                    'name' => $faker->catchPhrase,
                    'price' => $faker->randomFloat(2, 20, 1000), //entre 20 e 1000
                    'stock' => rand(1, 100),
                    'image' => $faker->imageUrl(640, 480, 'products', true),
                    'user_id' => rand(1, 50) //fk
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240414_211403_seed_product_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240414_211403_seed_product_table cannot be reverted.\n";

        return false;
    }
    */
}
