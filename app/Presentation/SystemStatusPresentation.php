<?php

declare(strict_types=1);

namespace app\Presentation;

use app\Domain\SystemStatus;
use support\Request;
use support\Response;

class SystemStatusPresentation
{
    public function getSystemStatus(Request $request): Response
    {
        $system = [];
        $system['cpu_info'] = (new SystemStatus())->getCPUInfo();
        $system['memory_usage'] = (new SystemStatus())->getMemoryUsage();
        $system['disk_usage'] = (new SystemStatus())->getDiskUsage();
        $system['available_ips'] = (new SystemStatus())->getAvailableIPs();
        return json(200, [
            'status' => 'success',
            'data' => $system
        ]);
    }
}