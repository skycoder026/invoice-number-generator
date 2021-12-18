<?php

namespace Skycoder\InvoiceNumberGenerator;

use Skycoder\InvoiceNumberGenerator\Models\InvoiceNumber;

class InvoiceNumberGeneratorService
{
    private $year = '';
    private $prefix = 'inv';
    private $company_id = null;
    private $start_at = 600000;
    private $invoice_no;


    public function currentYear()
    {
        $this->year = date('y');

        return $this;
    }

    public function prefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;

        return $this;
    }

    public function startAt($limit)
    {
        $this->start_at = $limit;

        return $this;
    }

    public function getInvoiceNumber($invoice_type)
    {

        $this->invoice_no = InvoiceNumber::query()
                    ->where('type', $invoice_type)
                    ->when($this->year != '', function($q) {
                        $q->where('year', $this->year);
                    })
                    ->when($this->company_id != null, function($q) {
                        $q->where('company_id', $this->company_id);
                    })
                    ->first();

        if (!optional($this->invoice_no)->next_id) {

            $this->invoice_no = InvoiceNumber::create([

                    'type'          => $invoice_type,
                    'year'          => $this->year,
                    'company_id'    => $this->company_id,
                    'next_id'       => $this->start_at

                ]);
        }

        $length = strlen($this->start_at);

        return $this->prefix
            . ($this->year != '' ? ('-' . $this->year) : '')
            . ($this->company_id != null ? ('-' . $this->company_id) : '')
            . str_pad($this->invoice_no->next_id, $length, "0", STR_PAD_LEFT);

    }

    public function setNextInvoiceNo()
    {
        $this->invoice_no->increment('next_id');
    }

}
