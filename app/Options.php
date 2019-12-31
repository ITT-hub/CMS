<?php
/*
 * Created 17.12.2019 15:20
 */

namespace ITTech\APP;

use ITTech\ORM\Connect;

/**
 * Class Options
 * @package ITTech\APP
 * @author Alexandr Pokatskiy
 * @copyright ITTechnology
 */
class Options extends Controller
{
    public static function get(string $key)
    {
        $model = OptionsModel::where("name", $key)->get();

        if(count($model) > 0)
        {
            return $model[0]->value;
        }

        return false;
    }

    /**
     * Регистрация параметра
     * @param string $param_name
     * @param string $param_value
     * @return bool
     */
    public static function set(string $param_name, string $param_value): bool
    {
        $option = new self();
        return $option->setParams($param_name, $param_value);
    }

    /**
     * Записать параметр
     * @param string $param_name
     * @param string $param_value
     * @return bool
     */
    protected function setParams(string $param_name, string $param_value): bool
    {
        $model = new OptionsModel();
        $model->name = $param_name;
        $model->value = $param_value;

        return $model->save();
    }
}