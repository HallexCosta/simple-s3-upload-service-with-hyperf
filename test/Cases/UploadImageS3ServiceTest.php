<?php

declare(strict_types=1);

namespace HyperfTest\Cases;

use Hyperf\Testing\TestCase;


final class UploadImageS3ServiceTest extends TestCase {

    public function testExecute() {
        $fp = fopen('./hallexcosta.jpg', '+w');
        // fwrite('');
        fclose($fp);

        

        $this->post('/uploads', [
            'photo' => $fp
        ]);

        fclose($fp);
    }
}