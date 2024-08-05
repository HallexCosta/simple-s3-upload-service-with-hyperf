<?php

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

final class NotFoundImageInBucketS3 extends ServerException {
    public function __construct(array $data, int $status) {
        parent::__construct(json_encode($data), $status);
    }
}