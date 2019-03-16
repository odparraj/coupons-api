<?php
namespace Modules\Base\Transformers;

use \League\Fractal\TransformerAbstract;
use Modules\Base\Models\BaseModel;

class SimpleTransformer extends TransformerAbstract
{

    public function transform(/*BaseModel*/ $model)
    {
        return [
            'id' => $model->uuid
        ];
    }

}