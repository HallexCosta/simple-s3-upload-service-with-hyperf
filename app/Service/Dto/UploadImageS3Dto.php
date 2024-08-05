<?php

namespace App\Service\Dto;

use \Hyperf\HttpMessage\Upload\UploadedFile;

final class UploadImageS3Dto extends AbstractDto {
    public UploadedFile $photo;
}