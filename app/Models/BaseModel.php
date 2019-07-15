<?php

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function getModelName()
    {
        if (isset($this->modelName)) {
            return $this->modelName;
        }

        $modelName = array_last(explode('\\', get_class($this)));

        return preg_replace('/(?<!\ )[A-Z]/', ' $0', $modelName);
    }
}
