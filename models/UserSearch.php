<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * UserSearch represents the model behind the search form of `app\models\User`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ssn', 'address_num', 'zip_code'], 'integer'],
            [['name', 'sexo', 'image', 'address', 'address_neighborhood', 'address_complement', 'city', 'state', 'cell_phone', 'cell_phone_verified_at', 'email', 'email_verified_at', 'password_hash', 'auth_key'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ssn' => $this->ssn,
            'address_num' => $this->address_num,
            'zip_code' => $this->zip_code,
            'cell_phone_verified_at' => $this->cell_phone_verified_at,
            'email_verified_at' => $this->email_verified_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'address_neighborhood', $this->address_neighborhood])
            ->andFilterWhere(['like', 'address_complement', $this->address_complement])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'cell_phone', $this->cell_phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key]);

        return $dataProvider;
    }
}
