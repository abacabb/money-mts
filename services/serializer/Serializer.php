<?php

namespace app\services\serializer;


use yii\base\Model;
use yii\web\Response;
use yii\data\ArrayDataProvider;

/**
 * Сериализатор
 * В основном используется для сериализации возвращяемого контента
 *
 * Class Serializer
 * @package app\services\serializer
 */
class Serializer extends \yii\rest\Serializer
{
    public function serialize($data)
    {
        $data = $this->prepareModels($data);
        $data = $this->prepareResponse($data);

        return parent::serialize($data);

    }

    /**
     * Подготовим списко моделей
     *
     * @param $data
     * @return array|ArrayDataProvider
     */
    protected function prepareModels($data)
    {
        if (is_array($data)) {
            $first = reset($data);
            if ($first instanceof Model) {
                return new ArrayDataProvider([
                    'allModels' => $data,
                    'pagination' => false,
                ]);
            }
        }

        return $data;
    }

    /**
     * @param $data
     * @return mixed
     */
    protected function prepareResponse($data)
    {
        if ($data instanceof Response) {
            $data->content = parent::serialize($data->data);
        }

        return $data;
    }
}