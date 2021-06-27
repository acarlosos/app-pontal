<?php
namespace App\Layout\Entrada;

use App\Models\Remessa;

class LayoutPadrao
{
    protected $remessa;
    protected $total;

    public function getRemessa()
    {
        return $this->remessa;
    }
    public function setRemessa(Remessa $remessa)
    {
        $this->remessa = $remessa;
    }
}
