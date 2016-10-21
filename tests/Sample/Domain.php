<?php
namespace Cadre\CliAdr\Sample;

class Domain
{
    public function __invoke($params)
    {
        return [
            'success' => true,
            'params' => $params,
        ];
    }
}
