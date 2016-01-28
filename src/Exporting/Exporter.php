<?php

namespace Exporting;

interface Exporter
{
    public function export(Exportable $exportable);
}
 