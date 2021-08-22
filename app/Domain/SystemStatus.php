<?php

namespace app\Domain;

class SystemStatus
{
    public function getCPUInfo()
    {
        $cpu = [];
        exec("cat /proc/cpuinfo", $details);
        $cpu['name'] = trim(explode(':', $details[4])[1]);
        $command = "cat /proc/cpuinfo | grep processor | wc -l";
        $cpu['cores'] = trim(shell_exec($command));
        $load_avg = sys_getloadavg();
        foreach(['1M', '5M', '15M'] as $key => $time) {
            $cpu['load_avg'][$time] = $load_avg[$key];
        }
        exec("lscpu | grep MHz", $all_mhz);
        foreach(['current', 'max'] as $key => $value) {
            $current_mhz = preg_split('/ +/', $all_mhz[$key]);
            $cpu['mhz'][$value] = end($current_mhz);
        }
        return $cpu;
    }

    public function getMemoryUsage()
    {
        $output=null;
        exec('free', $output);
        $names = preg_split('/ +/', $output[0]);
        $names[0] = 'Name';
        unset($output[0]);
        $memoirs_to_show = [];
        foreach ($output as $memory) {
            $memory = preg_split('/ +/', $memory);
            foreach ($names as $key => $memory_name) {
                $memoirs_to_show[$memory[0]][$memory_name] = isset($memory[$key]) ? $memory[$key] : "0"; 
            }
            unset($memoirs_to_show[$memory[0]]['Name']);
        }
        return $memoirs_to_show;
    }

    public function getDiskUsage()
    {
        exec ('df |grep sd', $available_disks);
        $fields = ['fileSystem', 'total', "used", "free", "percentageUsed"];
        $disks_to_show = [];
        foreach ($available_disks as $disk) {
            $disk = preg_split('/ +/', $disk);
            foreach ($fields as $key => $field) {
                $disks_to_show[$disk[0]][$field] = $disk[$key];
            }
        }
        return $disks_to_show;
    }

    public function getAvailableIPs()
    {
        exec("ip -o a show | cut -d ' ' -f 2,7", $available_ips);
        return $available_ips;
    }
}