<?php 

namespace App\Service;
use App\Service\Dto\AbstractDto;
use App\Service\Dto\ListImagesS3Dto;
use League\Flysystem\Filesystem;

final class ListImagesS3Service extends AbstractService {
    public function __construct(private readonly Filesystem $s3)
    {

    }

    public function execute(AbstractDto $dto): array
    {
        if (!($dto instanceof ListImagesS3Dto)) {
            throw new \InvalidArgumentException('Expected instance of UploadImageS3Dto');
        }

        return $this->s3->listContents($dto->directory)->toArray();
    }
}