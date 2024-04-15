<?php

use yii\db\Migration;

/**
 * Class m240415_121704_seed_user_table
 */
class m240414_130754_seed_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $faker = \Faker\Factory::create();

        $this->insert(
            'user',
            [
                'name' => 'admin',
                'sexo' => 'male',
                'image' => $faker->imageUrl(640, 480, 'user', true),
                'ssn' => rand(11111111111, 99999999999),
                'address' => $faker->streetName,
                'address_neighborhood' => $faker->firstName,
                'address_num' => $faker->buildingNumber,
                //'address_complement' => $this->string(),
                'zip_code'=> rand(11111111,9999999),
                'city' => $faker->city,
                'state' => $faker->state,
                'cell_phone' => $faker->phoneNumber,
                'cell_phone_verified_at' => $faker->date('Y-m-d'),
                'email' => 'admin@mail.com',
                'email_verified_at' => $faker->date('Y-m-d'),
                'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
                //'auth_key' => $this->string(32), //->notNull()
            ]
        );

        $this->insertFake();
    }

    private function insertFake()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {

            $gender = $faker->randomElement(['male', 'female']);
            $dateAD = [null, $faker->date('Y-m-d')]; //now é usado como máx

            $this->insert(
                'user',
                [
                    'name' => $faker->name($gender),
                    'sexo' => $gender,
                    'image' => $faker->imageUrl(640, 480, 'user', true),
                    'ssn' => rand(11111111111, 99999999999),
                    'address' => $faker->streetName,
                    'address_neighborhood' => $faker->firstName,
                    'address_num' => $faker->buildingNumber,
                    //'address_complement' => $this->string(),
                    'zip_code'=> rand(11111111,9999999),
                    'city' => $faker->city,
                    'state' => $faker->state,
                    'cell_phone' => $faker->phoneNumber,
                    'cell_phone_verified_at' => $dateAD[array_rand($dateAD)],
                    'email' => $faker->safeEmail,
                    'email_verified_at' => $dateAD[array_rand($dateAD)],
                    'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('senha'),
                    //'auth_key' => $this->string(32), //->notNull()
                ]
            );
        }
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240415_121704_seed_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240415_121704_seed_user_table cannot be reverted.\n";

        return false;
    }
    */
}
