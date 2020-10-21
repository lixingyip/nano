English | [中文](./README-CN.md)

<p align="left">
  <a href="https://secure.php.net/"><img src="https://img.shields.io/badge/php-%3E=7.3-brightgreen.svg?maxAge=2592000" alt="Php Version"></a>
  <a href="https://github.com/swoole/swoole-src"><img src="https://img.shields.io/badge/swoole-%3E=4.5-brightgreen.svg?maxAge=2592000" alt="Swoole Version"></a>
  <a href="https://github.com/hyperf/nano/blob/master/LICENSE"><img src="https://img.shields.io/github/license/hyperf/nano.svg?maxAge=2592000" alt="Nano License"></a>
</p>

# Nano Fast Api Framework

Nano is a zero-config, no skeleton, minimal Hyperf distribution. This project is based on Nano for secondary packaging, which can quickly develop high-concurrency and fast-response api applications.

## 功能

* Route
* Data Model
* Single Entry
* Middleware
* globalization
* Log
* ...

## Start

```bash
php bin/nano start
```

## Benchmark

```bash
/ # ab -n 1000 -c 100 http://10.10.107.151:9511/
This is ApacheBench, Version 2.3 <$Revision: 1879490 $>
Copyright 1996 Adam Twiss, Zeus Technology Ltd, http://www.zeustech.net/
Licensed to The Apache Software Foundation, http://www.apache.org/

Benchmarking 10.10.107.151 (be patient)
Completed 100 requests
Completed 200 requests
Completed 300 requests
Completed 400 requests
Completed 500 requests
Completed 600 requests
Completed 700 requests
Completed 800 requests
Completed 900 requests
Completed 1000 requests
Finished 1000 requests


Server Software:        Hyperf
Server Hostname:        10.10.107.151
Server Port:            9511

Document Path:          /
Document Length:        11 bytes

Concurrency Level:      100
Time taken for tests:   0.705 seconds
Complete requests:      1000
Failed requests:        0
Total transferred:      148000 bytes
HTML transferred:       11000 bytes
Requests per second:    1419.15 [#/sec] (mean)
Time per request:       70.465 [ms] (mean)
Time per request:       0.705 [ms] (mean, across all concurrent requests)
Transfer rate:          205.11 [Kbytes/sec] received

Connection Times (ms)
              min  mean[+/-sd] median   max
Connect:        1   15   7.3     15      29
Processing:     6   52  17.2     50     107
Waiting:        3   48  18.3     46     103
Total:          7   68  16.5     66     117

Percentage of the requests served within a certain time (ms)
  50%     66
  66%     72
  75%     77
  80%     80
  90%     90
  95%     98
  98%    110
  99%    116
 100%    117 (longest request)
```