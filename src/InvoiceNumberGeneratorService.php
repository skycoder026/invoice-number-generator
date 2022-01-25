<?php

namespace Skycoder\InvoiceNumberGenerator;

use Skycoder\InvoiceNumberGenerator\Models\InvoiceNumber;

class InvoiceNumberGeneratorService
{
    private $invoice_no;
    private $year           = '';
    private $others         = '';
    private $prefix         = 'inv';
    private $buyer_id       = null;
    private $company_id     = '';
    private $start_at       = 600000;


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
    

    public function setBuyerId($buyer_id)
    {
        $this->buyer_id = $buyer_id;

        return $this;
    }
    

    public function setOthers($others)
    {
        $this->others = $others;

        return $this;
    }

    public function startAt($limit)
    {
        $this->start_at = $limit;

        return $this;
    }

    public function getInvoiceNumber($invoice_type, $is_update = false)
    {
        $this->saveInvoiceNumber($invoice_type);

        $length = strlen($this->start_at);

        $invoice_no = $this->prefix
            . $this->year
            . $this->company_id
            . str_pad($this->invoice_no->next_id, $length, "0", STR_PAD_LEFT);


        if($is_update) {

            $this->invoice_no->increment('next_id');
        }

        return $invoice_no;

    }

    public function getNextInvoiceId($invoice_type)
    {
        $this->saveInvoiceNumber($invoice_type);
        
        return $this->invoice_no->next_id;
    }

    public function setNextInvoiceNo()
    {
        $this->invoice_no->increment('next_id');
    }
    
    public function saveInvoiceNumber($invoice_type)
    {

        $this->invoice_no = InvoiceNumber::query()
                    ->where('type', $invoice_type)
                    ->when($this->others != '', function($q) {
                        $q->where('others', $this->others);
                    })
                    ->when($this->year != '', function($q) {
                        $q->where('year', $this->year);
                    })
                    ->when($this->company_id != null, function($q) {
                        $q->where('company_id', $this->company_id);
                    })
                    ->when($this->buyer_id != null, function($q) {
                        $q->where('buyer_id', $this->buyer_id);
                    })
                    ->first();

        if (!optional($this->invoice_no)->next_id) {

            $this->invoice_no = InvoiceNumber::create([

                    'type'          => $invoice_type,
                    'year'          => $this->year,
                    'others'        => $this->others,
                    'buyer_id'      => $this->buyer_id,
                    'company_id'    => $this->company_id,
                    'next_id'       => $this->start_at

                ]);
        }


        return $this;
    }

}
