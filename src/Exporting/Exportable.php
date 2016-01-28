<?php

namespace Exporting;

/**
 * Objects which implement this interface will return an array which can be used for exporting
 * Interface Exportable
 */
interface Exportable
{
    /**
     * @return array
     */
    public function getExportArray();
}
