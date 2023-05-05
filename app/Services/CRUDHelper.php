<?php


namespace App\Services;


class CRUDHelper
{
    static function delete($model, $id): bool
    {
        $obj = $model::find($id);
        if($obj){
            if($obj->delete()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }

    }
}
