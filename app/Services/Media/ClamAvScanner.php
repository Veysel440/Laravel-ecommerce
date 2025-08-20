<?php

namespace App\Services\Media;


class ClamAvScanner
{
    public function scan(string $contents): bool
    {
        if (!config('media.clamav.enabled')) return true;

        $host = config('media.clamav.host');
        $port = (int) config('media.clamav.port');
        $timeout = (int) config('media.clamav.timeout');

        $fp = @stream_socket_client("tcp://{$host}:{$port}", $errno, $errstr, $timeout);
        if (!$fp) return false;

        fwrite($fp, "zINSTREAM\0");
        $len = strlen($contents);
        $pos = 0;
        while ($pos < $len) {
            $chunk = substr($contents, $pos, 8192);
            $size = pack('N', strlen($chunk));
            fwrite($fp, $size.$chunk);
            $pos += strlen($chunk);
        }
        fwrite($fp, pack('N', 0)); // end
        $resp = stream_get_contents($fp);
        fclose($fp);

        return is_string($resp) && str_contains($resp, 'OK');
    }
}
