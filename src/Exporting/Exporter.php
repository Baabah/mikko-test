<?php

namespace Exporting;

/**
 * This interface implements a generic export() function, which can be used for various outputting methods
 * Interface Exporter
 */
interface Exporter
{
    /**
     * Export an Exportable object using a certain implementation
     * @param Exportable $exportable
     * @return bool
     */
    public function export(Exportable $exportable);
}
